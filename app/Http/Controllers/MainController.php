<?php

namespace App\Http\Controllers;

use App\People;
use App\Films;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function lists()
    {
        return view('lists');
    }

    public function save(Request $request)
    {
        $data = $request->all();

        ($data['type'] == 'people') ? $this->savePeople($data['data']) : $this->saveFilms($data['data']);

        return response('Success');
    }

    public function savePeople($data)
    {
        foreach ($data as $key => $value) {
            $value['films'] = (isset($value['films'])) ? implode(",", $value['films']) : "" ;
            $value['species'] = (isset($value['species'])) ? implode(",", $value['species']) : "" ;
            $value['vehicles'] = (isset($value['vehicles'])) ? implode(",", $value['vehicles']) : "" ;
            $value['starships'] = (isset($value['starships'])) ? implode(",", $value['starships']) : "" ;

            $people = People::firstOrCreate([
                'url' => $value['url'],
                'name' => $value['name'],
                'height' => $value['height'],
                'mass' => $value['mass'],
                'hair_color' => $value['hair_color'],
                'skin_color' => $value['skin_color'],
                'eye_color' => $value['eye_color'],
                'birth_year' => $value['birth_year'],
                'gender' => $value['gender'],
                'homeworld' => $value['homeworld'],
                'films' => $value['films'],
                'species' => $value['species'],
                'vehicles' => $value['vehicles'],
                'starships' => $value['starships'],
            ]);
        }
    }

    public function saveFilms($data)
    {
        
        foreach ($data as $key => $value) {
            $value['vehicles'] = (isset($value['vehicles'])) ? implode(",", $value['vehicles']) : "" ;
            $value['starships'] = (isset($value['starships'])) ? implode(",", $value['starships']) : "" ;
            $value['characters'] = (isset($value['characters'])) ? implode(",", $value['characters']) : "" ;
            $value['planets'] = (isset($value['planets'])) ? implode(",", $value['planets']) : "" ;
            $value['species'] = (isset($value['species'])) ? implode(",", $value['species']) : "" ;

            $film = Films::firstOrCreate([
                'url' => $value['url'],
                'title' => $value['title'],
                'episode_id' => $value['episode_id'],
                'opening_crawl' => $value['opening_crawl'],
                'director' => $value['director'],
                'producer' => $value['producer'],
                'release_date' => $value['release_date'],
                'characters' => $value['characters'],
                'planets' => $value['planets'],
                'starships' => $value['starships'],
                'vehicles' => $value['vehicles'],
                'species' => $value['species'],
            ]);
        }
    }

    public function getFilms(Request $request)
    {
        $data = $request->all();

        $films = [];
        foreach ($data['data'] as $key => $value) {
            $film = Films::where('url', $value)->first();
            array_push($films, $film->title);
        }
        return response($films);
    }

    public function getChars(Request $request)
    {
        $data = $request->all();

        $people = [];
        foreach ($data['data'] as $key => $value) {
            $person = People::where('url', $value)->first();
            if(strlen($person['name'])>0){
                array_push($people, $person['name']);
            }
        }
        return response($people);
    }

}
