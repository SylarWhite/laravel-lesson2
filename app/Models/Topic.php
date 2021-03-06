<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug','premium','price'];

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function link($params=[])
    {
        return route('topics.show',array_merge([$this->id,$this->slug],$params));
    }

    public function buyers()
    {
        return $this->belongsToMany(User::class,'user_topic')->withTimestamps();
    }

    public function premiumTopic()
    {
        $user = \Auth::user();
        $balance = $user->money - $this->price;
        if($balance >= 0){
            \DB::beginTransaction();
            try{
                $user->money = $balance;
                $earn = $user->hasRole('Verified') ? intval($this->price*0.75) :intval($this->price*0.4);
                $this->amount += $earn;
                $this->buyer_count += 1;

                $records = new Record();
                $records->user_id = \Auth::id();
                $records->money = $this->price;
                $records->type = 3;
                $records->topic_id = $this->id;
                $records->status = 1;
                $records->save();

                $records = new Record();
                $records->user_id = $this->user_id;
                $records->money = $earn;
                $records->type = 1;
                $records->topic_id = $this->id;
                $records->status = 1;
                $records->save();

                $user->save();
                $this->buyers()->sync([$user->id]);
                $this->save();
                $this->user->money += $earn;
                $this->push();

                \DB::commit();
                return true;
            }catch (\Exception $exception){
                \DB::rollback();
                return false;
            }
        }
        return false;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithOrder($query, $order)
    {
        switch ($order){
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentReplied();
                break;
        }
        return $query->with('user','category');
    }


    public function scopeRecent($query)
    {
        return $query->orderBy('created_at','desc');
    }

    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at','desc');
    }

    public function updateReplyCount()
    {
        $this->reply_count = $this->replies->count();
        $this->save();
    }

}
