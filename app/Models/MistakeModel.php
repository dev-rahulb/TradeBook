<?php
namespace App\Models;

use CodeIgniter\Model;

class MistakeModel extends Model
{
    protected $table = 'mistakes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['description'];
}
