<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 03 Oct 2018 22:53:42 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CmsPage
 *
 * @property int $id
 * @property string $page_title
 * @property string $page_description
 * @property string $meta_title
 * @property string $meta_keyword
 * @property string $meta_description
 * @property string $slug
 * @property bool $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class CmsPage extends Eloquent
{
    protected $casts = [
        'status' => 'bool'
    ];

    protected $fillable = [
        'page_title',
        'page_description',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'slug',
        'status'
    ];
}
