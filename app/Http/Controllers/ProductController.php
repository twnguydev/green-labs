<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;

class ProductController extends Controller
{
    public function showNewAd()
    {
        $products = Product::all();
        return view('new_ad', ['products' => $products]);
    }

    public function createAd(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'price' => 'required',
                'category' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'quantity' => 'required',
            ]);

            $user = auth()->user();

            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/products', $imageName);
            } else {
                $imageName = null;
            }

            Product::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'user_id' => $user->id,
                'category_id' => $request->input('category'),
                'quantity' => $request->input('quantity'),
                'image' => $imageName ? 'products/' . $imageName : 'products/default-picture.png',
            ]);

            return redirect('/dashboard')->withSuccess('Annonce créée avec succès !');
        } else {
            return back()->with('status', 'Invalid method used to submit form');
        }
    }

    public function showAd($category_route, $ad_id)
    {
        $category = Category::where('route', $category_route)->first();

        if (!$category) {
            return redirect()->route('home')->withErrors('La catégorie demandée n\'existe pas.');
        }

        $product = Product::where('id', $ad_id)
            ->where('category_id', $category->id)
            ->first();

        if (!$product) {
            return redirect('/categories/' . $category_route)->with('errors', "L'annonce demandée n'existe pas.");
        }

        $reviews = Review::where('product_id', $product->id)->get();

        $user = User::find($product->user_id);
        $userLogged = auth()->user();

        $access = $userLogged && $userLogged->id === $user->id;

        return view('ad', ['product' => $product, 'category' => $category, 'user' => $user, 'reviews' => $reviews, 'access' => $access]);
    }

    public function createReview(Request $request, $category, $ad_id)
    {
        if ($request->isMethod('post')) {
            if (auth()->check()) {
                $user = auth()->user();
                $product = Product::find($ad_id);
    
                if ($product) {
                    $product->reviews()->create([
                        'rating' => $request->input('rating'),
                        'content' => $request->input('content'),
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                    ]);
    
                    return redirect('/categories/' . $product->category->route . '/' . $product->id)->withSuccess('Avis ajouté avec succès !');
                } else {
                    return back()->with('errors', 'Le produit associé à cet avis n\'existe pas.');
                }
            } else {
                return back()->with('errors', 'Vous devez être connecté pour ajouter un avis.');
            }
        } else {
            return back()->with('errors', 'Invalid method used to submit form');
        }
    }

    public function deleteAd(Request $request, $category, $ad_id)
    {
        if ($request->isMethod('post')) {
            $product = Product::find($ad_id);

            if ($product) {
                $reviews = Review::where('product_id', $product->id)->get();

                foreach ($reviews as $review) {
                    $review->delete();
                }

                $product->delete();
                return redirect('/dashboard')->withSuccess('Annonce supprimée avec succès !');
            } else {
                return back()->with('errors', 'L\'annonce demandée n\'existe pas.');
            }
        } else {
            return back()->with('errors', 'Invalid method used to submit form');
        }
    }

    public function showUpdateAd($category, $ad_id)
    {
        $user = auth()->user();

        $product = Product::find($ad_id);
        $author = User::find($product->user_id);

        if ($user->id !== $author->id) {
            return back()->with('errors', 'Vous n\'êtes pas autorisé à modifier cette annonce.');
        }

        if ($product) {
            $categories = Category::all();
            return view('update_ad', ['product' => $product, 'categories' => $categories]);
        } else {
            return redirect('/dashboard')->with('errors', 'L\'annonce demandée n\'existe pas.');
        }
    }

    public function updateAd(Request $request, $category, $ad_id)
    {
        if ($request->isMethod('post')) {
            $user = auth()->user();

            $product = Product::find($ad_id);
            $author = User::find($product->user_id);

            if ($user->id !== $author->id) {
                return back()->with('errors', 'Vous n\'êtes pas autorisé à modifier cette annonce.');
            }

            if ($product) {
                $request->validate([
                    'title' => 'required',
                    'description' => 'required',
                    'price' => 'required',
                    'category' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    'quantity' => 'required',
                ]);

                $product->update([
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'price' => $request->input('price'),
                    'category_id' => $request->input('category'),
                    'quantity' => $request->input('quantity'),
                ]);

                if ($request->hasFile('image')) {
                    $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                    $request->file('image')->storeAs('public/products', $imageName);
                    $product->image = 'products/' . $imageName;
                    $product->save();
                }

                return redirect('/dashboard')->withSuccess('Annonce mise à jour avec succès !');
            } else {
                return back()->with('errors', 'L\'annonce demandée n\'existe pas.');
            }
        } else {
            return back()->with('errors', 'Invalid method used to submit form');
        }
    }
}
