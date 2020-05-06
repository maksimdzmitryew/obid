<?php

namespace App;

use App\Festival;
use App\EventCategory;
use App\Traits\Imageable;
use App\Traits\Favoritable;
use App\Traits\GeneralTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use Imageable;
    use Favoritable;
    use GeneralTrait;
    use Translatable;

    protected $fillable = [
        'published',
        'festival_id',
        'category_id',
        'gallery_id',
        'promoting_up',
        'promoting',
        'facebook',
    ];

    protected $with = [
        'category',
        'holdings',
        'directors',
        'image'
    ];

    public $translatedAttributes = [
        'title',
        'slug',
        'description',
        'body',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'promoting'         => 'boolean',
        'promoting_up'      => 'boolean',
        'published'         => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('order', function (Builder $builder) {
        //     $builder->orderBy('created_at', 'desc');
        // });
    }

    public function festival()
    {
        return $this->belongsTo('App\Festival');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function gallery()
    {
        return $this->belongsTo('App\Gallery');
    }

    public function holdings()
    {
        return $this->hasMany('App\EventHolding');
    }

    public function vocations()
    {
        return $this->belongsToMany('App\Vocation')->withPivot('order');
    }

    public function eventVocations()
    {
        return $this->hasMany('App\EventVocation');
    }

    public function persons()
    {
        return $this->belongsToMany('App\Artist');
    }

    public function directors()
    {
        return $this->persons()->wherePivot('role', 'director');
    }

    public function artists()
    {
        return $this->persons()->wherePivot('role', 'artist');
    }

    public function producers()
    {
        return $this->persons()->wherePivot('role', 'producer');
    }

    public function executiveProducers()
    {
        return $this->persons()->wherePivot('role', 'executive_producer');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function scopePromoting($query, $promoting = true)
    {
        return $query->where('promoting', $promoting);
    }

    /**
     * Fix facebook empty value null'ed by Laravel
     *
     * @param  string  $value
     * @return void
     */
    public function setFacebookAttribute($value)
    {
        if (is_null($value))
        {
            $this->attributes['facebook'] = '';
        }
    }

    public function getDayAttribute($value)
    {
        $date = new Carbon($value);

        return trans('general.date', [
            'day'   => $date->format('j'),
            'month' => $date->format('F'),
            'year'  => $date->format('Y')
        ]);
    }

    public static function duplicate(\Illuminate\Http\Request $request) : int
    {

    	# load relations, too
		$o_res 					= Event::findOrFail($request->id);
		# copy attributes
		$o_replica 				= $o_res->replicate();

		# save model before you recreate relations (so it has an id)
		$o_replica->push();
		# reset relations on EXISTING MODEL - this way we control which ones will be loaded
		$o_res->relations = [];
		# load relations on EXISTING MODEL
		$o_res->load('holdings', 'translations', 'directors');

		# re-sync everything
		foreach ($o_res->relations as $relationName => $items){
			foreach($items as $item => $values){
				unset($values->id);
				unset($values->slug);
				$values->title .= ' [copied from event #' . $values->event_id . ']';
				$values->locale = $values->locale;
				$o_replica->{$relationName}()->create($values->toArray());
			}
		}
	    return $o_replica->id;

    }
}
