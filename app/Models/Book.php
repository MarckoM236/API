<?php
namespace App\Models;

use Illuminate\Database\Capsule\Manager as DB;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //use HasFactory;


    //table
    protected $table="books";
    protected $fillable = ['title','image'];
}