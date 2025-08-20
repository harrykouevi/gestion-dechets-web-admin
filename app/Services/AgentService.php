<?php

namespace App\Services;

use App\Models\FeaturedUser;
use App\Models\User;
use App\Models\UserHistory;
use App\Models\Image;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Builder ;
use InvalidArgumentException;

class AgentService
{
    use ServiceTrait ;

    public function getAll(Array $relation = [], int $perPage = Null)
    {

        $params = [];

        if (!empty($relation)) $params['with'] = implode(',', $relation);
        if (!is_null($perPage)) $params['per_page'] = $perPage;

        $response = Http::withToken(session('token'))->withHeaders(['Accept' => 'application/json'])
        ->get(env('API_SERVICE_URL') .'/api/users/collecteur/get', $params);

        if ($response->successful()) {
            $data = $response->json()['data'];
            return collect($data);
        }

        // Gérer les erreurs ici
        abort(500, 'Erreur lors de la récupération des posts.');

    }


    public function get($id,Array $relation=[])
    {
        $params = [];
        if (!empty($relation)) $params['with_relations'] = 'true';

        // $cached_data = Cache::get("post_{$id}") ;
        // if(!is_null($cached_data)){
        //     return $cached_data;
        // }

        $response = Http::withToken(session('token'))->withHeaders(['Accept' => 'application/json'])
        ->get(env('API_SERVICE_URL') .'/api/users/collecteur/get/'.$id, $params);
        if ($response->successful()) {
            $data = $response->json()['data'];
            // Cache::put("post_{$id}", $data, now()->addMinutes(5));
            return $data;
        }

        // Gérer les erreurs ici
        abort(404, 'Erreur lors de la récupération des posts.');
    }

    public function create(array $data, $mediaFiles  = [])
    {
        // dd($data) ;
        $data['admin_id'] = session('user')['id'];
        $data["password_confirmation"] =  $data["password"] ;

        $http = Http::withToken(session('token'))
          ->asMultipart() // Nécessaire pour les fichiers
                    ->withHeaders(['Accept' => 'application/json']);


        foreach ($mediaFiles as $index => $media) {
            if (!empty($media['file'])) {
                $http = $this->attachFileToHttp($http, "medias[$index][file]", $media['file']);
            }

            $data["medias[$index][type]"] = 'image';
            if (isset($media['type'])) {
                $data["medias[$index][type]"] = $media['type'];
            }
        }

        $endpoint = env('API_SERVICE_URL') . "/api/auth/register/collecteur";

        $response = $http->post($endpoint, $data);

        if ($response->successful()) {
            $data = $response->json()['data'];
            // Cache::put("post_{$data['id']}", $data, now()->addMinutes(5));
        }

        return $this->render($response);
    }

    public function update(string $id, array $data , $mediaFiles  = [])
    {
        $data['admin_id']= session('user')['id'];

        $http = Http::withToken(session('token'))
        ->asMultipart() // Nécessaire pour les fichiers
        ->withHeaders(['Accept' => 'application/json']);

         // Spoof de la méthode PATCH
        $http = $http->attach('_method', 'PATCH');

        foreach ($mediaFiles as $index => $media) {

            if (!empty($media['file'])) {
                $http = $this->attachFileToHttp($http, "medias[$index][file]", $media['file']);
            }

            $data["medias[$index][type]"] = 'image';
            if (isset($media['type'])) {
                $data["medias[$index][type]"] = $media['type'];
            }
        }


        $response = $http->post(env('API_SERVICE_URL') . "/api/blogs/post/update/".$id, $data);

        if ($response->successful()) {
            $data = $response->json()['data'];
            // Cache::put("post_{$data['id']}", $data, now()->addMinutes(5));
        }

        return $this->render($response);
    }

    // public function delete($id)
    // {
    //     $response = Http::withToken(session('token'))
    //         ->withHeaders(['Accept' => 'application/json'])
    //         ->delete(env('API_SERVICE_URL') . "/api/blogs/post/delete/".$id);

    //     if ($response->successful()) {
    //         Cache::forget("post_{$id}");
    //     }

    //     return $this->render($response);
    // }

}
