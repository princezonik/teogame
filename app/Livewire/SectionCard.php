<?php

namespace App\Livewire;

use Livewire\Component;

class SectionCard extends Component
{
    public $title = "Be Part of the Community";
    public $communities = [
        
        [
            'title' => 'Chat',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="5em" height="5em" style="-ms-transform:rotate(360deg);-webkit-transform:rotate(360deg)" viewBox="0 0 24 24" transform="rotate(360)"><path d="M8 5a3 3 0 110 6 3 3 0 010-6zm8 0a3 3 0 110 6 3 3 0 010-6zm-8 8c3.866 0 7 1.343 7 3v3H1v-3c0-1.657 3.134-3 7-3zm8 0c3.866 0 7 1.343 7 3v3h-6v-3c0-1.117-.66-2.15-1.775-2.982L16 13z" fill="#fff"></path></svg>',
        ],
        [
            'title' => 'Suggest',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="5em" height="5em" style="-ms-transform:rotate(360deg);-webkit-transform:rotate(360deg)" viewBox="0 0 24 24" transform="rotate(360)"><path d="M12 6a6 6 0 013 11.197V19a1 1 0 01-1 1h-4a1 1 0 01-1-1v-1.803A6 6 0 0112 6zm2 15v1a1 1 0 01-1 1h-2a1 1 0 01-1-1v-1h4zm6-10h3v2h-3v-2zM1 11h3v2H1v-2zM12.992.999v3h-2v-3h2zM4.925 3.516l2.121 2.121-1.414 1.414L3.51 4.93l1.414-1.414zm12.027 2.116l2.121-2.12 1.415 1.413-2.122 2.122-1.414-1.415z" fill="#fff"></path></svg>',
        ],
        [
            'title' => 'Collaborate',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="5em" height="5em" style="-ms-transform:rotate(360deg);-webkit-transform:rotate(360deg)" viewBox="0 0 640 512" transform="rotate(360)"><path d="M488 192H336v56c0 39.7-32.3 72-72 72s-72-32.3-72-72V126.4l-64.9 39C107.8 176.9 96 197.8 96 220.2v47.3l-80 46.2C.7 322.5-4.6 342.1 4.3 357.4l80 138.6c8.8 15.3 28.4 20.5 43.7 11.7L231.4 448H368c35.3 0 64-28.7 64-64h16c17.7 0 32-14.3 32-32v-64h8c13.3 0 24-10.7 24-24v-48c0-13.3-10.7-24-24-24zm147.7-37.4L555.7 16C546.9.7 527.3-4.5 512 4.3L408.6 64H306.4c-12 0-23.7 3.4-33.9 9.7L239 94.6c-9.4 5.8-15 16.1-15 27.1V248c0 22.1 17.9 40 40 40s40-17.9 40-40v-88h184c30.9 0 56 25.1 56 56v28.5l80-46.2c15.3-8.9 20.5-28.4 11.7-43.7z" fill="#fff"></path></svg>',
        ],

        [
            'title' => 'Ask',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="5em" height="5em" style="-ms-transform:rotate(360deg);-webkit-transform:rotate(360deg)" viewBox="0 0 24 24" transform="rotate(360)"><path d="M15.066 11.252l-.895.918c-.724.724-1.172 1.328-1.172 2.828h-2v-.5c0-1.104.448-2.104 1.172-2.828l1.243-1.258A2 2 0 1010 8.998H8a4 4 0 018 0c0 .88-.356 1.677-.933 2.254zM13 18.998h-2v-2h2m-1-15c-5.523 0-10 4.477-10 10 0 5.524 4.477 10 10 10 5.524 0 10-4.476 10-10 0-5.523-4.476-10-10-10z" fill="#fff"></path></svg>',
        ],
    ];
    public function render()
    {
        return view('livewire.section-card');
    }
}
