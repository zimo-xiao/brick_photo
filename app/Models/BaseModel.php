<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    public function rawMultipleCounts(array $queries, $f)
    {
        // TODO: 规范化代码
        /**
         * 语法：
         *  - a => [b => c, d => [e, f]]
         *  - 搜索 b 等于 c 的条件，并且 d 等于 e 或 f
         */
        if (count($queries)>0) {
            // 生成raw query
            $queryString = '';
            foreach ($queries as $index => $query) {
                $sumQuery = [];
                foreach ($query as $i => $q) {
                    if (is_array($q)) {
                        $sumQuery[] = $i.' IN (\''.join("','", $q).'\')';
                    } else {
                        $sumQuery[] = $i.'=\''.$q.'\'';
                    }
                }
                // HACK: 因为数字无法是变量名，所以加了个placeholder
                $queryString .= 'sum('.implode($sumQuery, ' AND ').') "placeholder_'.$index.'", ';
            }
            // 输入自定义函数实现共享query查询，自定义函数输入为model，输出也应该为model
            $result = $f($this->selectRaw(trim($queryString, ', ')))->get()[0]->toArray();
            // 去掉placeholder
            $out = [];
            foreach ($result as $k => $r) {
                $out[\str_replace('placeholder_', '', $k)] = $r;
            }
            return $out;
        } else {
            return [];
        }
    }
}