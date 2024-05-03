<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address',
        'city',
        'country',
        'postal_code',
        'profile_picture',
        'biography',
        'role',
        'birthdate',
        'confirmation_token',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the products for the user.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function count()
    {
        return $this->products->count();
    }

    /**
     * Get the reviews for the user.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function getAverageRatingAttribute()
    {
        $averageRating = $this->reviews()->avg('rating');

        if (is_numeric($averageRating)) {
            return round($averageRating, 1);
        } else {
            return 0;
        }
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'user_receiver_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(ChatMessage::class, 'user_sender_id');
    }
}
