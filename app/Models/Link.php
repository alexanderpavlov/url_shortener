<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';


    /**
     * Получаем запись из таблицы по полному url
     * @param $url
     * @return mixed
     */
    public function getLinkByUrl($url)
    {
        return $this->where('url', $url)->first();
    }

    public function getLinkByShortId($shortId)
    {
        return $this->find($this->getIdByShortId($shortId));
    }

    /**
     * Добавляем url в таблицу и вовращаем id в 36-ой системе исчисления
     * @param $url
     * @return mixed
     */
    public function addUrl($url)
    {
        $id = $this->insertGetId(['url' => $url]);

        return $this->getShortId($id);
    }

    /**
     * Возвращаем id в 36-ой системе исчисления
     * @param null $id
     * @return string
     */
    public function getShortId($id = null)
    {
        $id = $id ? : $this->id;

        return base_convert($id, 10, 36);
    }

    /**
     * Конвертация короткого id в полный id
     * @param $shortId
     * @return string
     */
    public function getIdByShortId($shortId)
    {
        return base_convert($shortId, 36, 10);
    }
}