<?php

namespace App\Http\Livewire\News;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Models\News\News;

class CreateNews extends Component
{
    use WithFileUploads;

    public $type;
    public $title;
    public $subtitle;
    public $image;
    public $lead;
    public $body;
    public $publicationDateAt;
    public $untilAt;

    public $newsToEdit;
    public $news_id;
    public $form;

    protected function messages(){
        return [
            'type.required'     => 'Debe ingresar tipo de noticia.',
            'title.required'    => 'Debe ingresar un título.',
            'subtitle.required' => 'Debe ingresar un subtítulo.',
            'image.required'    => 'Debe ingresar una imágen',
            'lead.required'     => 'Debe ingresar un lead (Ideas más importantes de noticia).',
            'body.required'     => 'Debe ingresar el cuerpo para su noticia.',
            'untilAt.required'  => 'Debe ingresar una fecha limite de públicación',
        ];
    }

    public function mount($newsToEdit)
    {   
        if(!is_null($newsToEdit)){
            $this->newsToEdit = $newsToEdit;
            $this->setNews();
        }
    }

    public function render()
    {
        return view('livewire.news.create-news');
    }

    public function setNews(){
        if($this->newsToEdit){
            $this->news_id  = $this->newsToEdit->id;
            $this->type     = $this->newsToEdit->type;
            $this->untilAt  = $this->newsToEdit->until_at->format('Y-m-d');
            $this->title    = $this->newsToEdit->title;
            $this->subtitle = $this->newsToEdit->subtitle;
            //$this->image    = $this->newsToEdit->image;
            $this->lead     = $this->newsToEdit->lead;
            $this->body     = $this->newsToEdit->body;
        }
    }

    public function saveNews(){
        $this->validate([
            'type'      => 'required',
            'title'     => 'required',
            'subtitle'  => 'required',
            'image'     => 'required',
            'lead'      => 'required',
            'body'      => 'required',
            'untilAt'   => 'required'
        ]);

        $news = DB::transaction(function () {
            $news = News::updateOrCreate(
                [
                    'id'  =>  $this->news_id ? $this->news_id : '',
                ],
                [
                    'type'                  => $this->type,
                    'until_at'              => $this->untilAt,
                    'title'                 => $this->title,
                    'subtitle'              => $this->subtitle,
                    'lead'                  => $this->lead,
                    'body'                  => $this->body,
                    'publication_date_at'   => now(),
                    'user_id'               => Auth::user()->id
                ]
            );
            return $news;
        });

        $news->image = $this->image->storeAs('/ionline/news', 'news_'.$news->id.'_'.now()->format('Y_m_d_H_i_s').'.'.$this->image->extension(), 'gcs');
        $news->save();

        return redirect()->route('news.show', $news);
    }
}
