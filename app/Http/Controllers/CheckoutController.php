<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function __construct(protected Cart $cart)
    {
    }

    public function index()
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        return view('checkout.index', [
            'items' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
        ]);
    }

    public function store(Request $request)
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:32'],
            'country' => ['required', 'string', 'max:255'],
        ]);

        $items = $this->cart->items();

        foreach ($items as $line) {
            if ($line->quantity > $line->book->stock) {
                return redirect()->route('cart.index')->with(
                    'error',
                    "Not enough stock for \"{$line->book->title}\". Please adjust the quantity."
                );
            }
        }

        $shippingAddress = sprintf(
            "%s\n%s\n%s, %s\n%s",
            $data['name'],
            $data['address'],
            $data['city'],
            $data['postal_code'],
            $data['country']
        );


        $order = DB::transaction(function () use ($items, $shippingAddress) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'pending',
                'total' => $this->cart->subtotal(),
                'shipping_address' => $shippingAddress,
            ]);

            foreach ($items as $line) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $line->book->id,
                    'quantity' => $line->quantity,
                    'price' => $line->book->price,
                ]);
            }

            return $order;
        });

        // Stripe Checkout 
        $secret = config('services.stripe.secret');

        if (! $secret || str_contains($secret, 'your_secret_key')) {
            return redirect()->route('checkout.success', ['order' => $order->id, 'dev' => 1]);
        }

        Stripe::setApiKey($secret);

        $lineItems = $items->map(fn ($line) => [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $line->book->title,
                    'description' => 'by ' . $line->book->author,
                ],
                'unit_amount' => (int) round($line->book->price * 100),
            ],
            'quantity' => $line->quantity,
        ])->toArray();

        $session = StripeSession::create([
            'mode' => 'payment',
            'line_items' => $lineItems,
            'customer_email' => auth()->user()->email,
            'success_url' => route('checkout.success', ['order' => $order->id])
                . '&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', ['order' => $order->id]),
            'metadata' => ['order_id' => $order->id],
        ]);

        $order->update(['stripe_session_id' => $session->id]);

        return redirect($session->url);
    }


    public function success(Request $request, Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $secret = config('services.stripe.secret');
        $isDev = $request->boolean('dev') || ! $secret || str_contains($secret, 'your_secret_key');

        if (! $isDev && $request->filled('session_id')) {
            Stripe::setApiKey($secret);
            $session = StripeSession::retrieve($request->input('session_id'));
            if ($session->payment_status !== 'paid') {
                return redirect()->route('checkout.cancel', ['order' => $order->id]);
            }
        }

        if ($order->status === 'pending') {
            DB::transaction(function () use ($order) {
                $order->update(['status' => 'paid']);

                foreach ($order->items as $item) {
                    $item->book()->decrement('stock', $item->quantity);
                }
            });

            $this->cart->clear();
        }

        return view('checkout.success', ['order' => $order->load('items.book')]);
    }

    public function cancel(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        return view('checkout.cancel', ['order' => $order]);
    }
}
