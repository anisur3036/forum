<?php

namespace App;

use App\User;
use App\Favorite;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
	protected $guarded = [];
	
    public function owner()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function favorites()
	{
		return $this->morphMany(Favorite::class, 'favorited');
	}

	public function favorite()
	{
		$attributes = ['user_id' => auth()->id()];
		if (! $this->isFavorited()) {
			$this->favorites()->create($attributes);
		}
	}

	public function isFavorited()
	{
		$attributes = ['user_id' => auth()->id()];

		return $this->favorites()->where($attributes)->exists();
	}
	
	
	
}
