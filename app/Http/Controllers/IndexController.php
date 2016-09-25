<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    private $linkModel;

    public function __construct()
    {
        $this->linkModel = new Link();
    }

    /**
     * Главная страница, здесь задаем ссылку и выводим короткую ссылку
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('index', ['link' => $request->session()->get('link')]);
    }


    /**
     * Редирект по короткой ссылке
     * @param $shortId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirectByShortLink($shortId)
    {
        $link = $this->linkModel->getLinkByShortId($shortId);

        if(!$link) {
            return view('errors.wrong_link', ['link' => $this->getShortLink($shortId)]);
        }

        return redirect($link->url);
    }

    /**
     * Добавляем ссылку в БД и возвращаем короткую ссылку
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postUrl(Request $request)
    {
        $input = $request->only('url');

        $validator = Validator::make(
            $input,
            [
                'url' => 'required|url|max:255'
            ],
            [
                'url.required' => 'Enter url!',
                'url.url' => 'Url is not valid!',
                'url.max' => 'Url max length is 255!',
            ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        $link = $this->linkModel->getLinkByUrl($input['url']);

        if($link) {
            $shortId = $link->getShortId();
        }
        else {
            $shortId = $this->linkModel->addUrl($input['url']);
        }

        return redirect('/')->with(['link' => $this->getShortLink($shortId)]);
    }

    /**
     * Возвращаем короткую ссылку по id
     * @param $shortId
     * @return string
     */
    private function getShortLink($shortId)
    {
        return 'http://'.$_SERVER["HTTP_HOST"].'/'.$shortId;
    }
}