<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $fillable = [
        'name',
        'company_name',
        'vat',
        'email',
        'address',
        'zipcode',
        'city',
        'primary_number',
        'secondary_number',
        'industry_id',
        'company_type',
        'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

   public function tasks()
    {
        return $this->hasMany(Task::class, 'client_id', 'id')
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'client_id', 'id')
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'client_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getAssignedUserAttribute()
    {
        return User::findOrFail($this->user_id);
    }

    public function fieldAttribute()
    {
        return $this->belongsToMany('App\Field_attribute', 'client_requirements', 'client_id', 'fieldattr_id')->select('id','client_id', 'fieldattr_id', 'name');
    }

    public function task(){
        return $this->hasMany('App\Models\Task');
    }
}
