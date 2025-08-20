<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use Illuminate\Support\Facades\Cache;


class QuestionService
{
    use ServiceTrait;

    /**
     * Récupère la liste paginée des posts avec ou sans relations.
     *
     * @param array|null $relation Relations à charger avec chaque post
     * @param int|null $perPage Nombre d'éléments par page
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function getAll(array $relation = [], int $perPage = null) : \Illuminate\Support\Collection
    {
        $params = [];

        if (!empty($relation)) {
            $params['with_relations'] = 'true';
        }

        if (!is_null($perPage)) {
            $params['per_page'] = $perPage;
        }

        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->get(env('API_SERVICE_URL') . '/api/blogs/question', $params);

        if ($response->successful()) {
            return collect($response->json()['data']);
        }

        abort(404, 'Erreur lors de la récupération des questions.');
    }

    /**
     * Récupère un post par son ID, avec ou sans relations.
     *
     * @param int|string $id
     * @param array $relations
     * @return array
     * @throws \Exception
     */
    public function get($id, array $relations = []) : Array
    {
        $params = [];

        if (!empty($relations)) {
            $params['with_relations'] = 'true';
        }

        $cached_data = Cache::get("question_{$id}") ;
        if(!is_null($cached_data)){
            return $cached_data;
        }

        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->get(env('API_SERVICE_URL') . '/api/blogs/question/' . $id, $params);

        if ($response->successful()) {
            Cache::put("question_{$id}", $response->json()['data'], now()->addMinutes(5));
            return $response->json()['data'];
        }

        throw new \Exception('Erreur lors de la récupération du post');
    }

    /**
     * Crée un nouveau post (éducatif ou standard) pour l’admin connecté.
     *
     * @param array $data Données du post
     * @return mixed
     */
    public function create(array $data)
    {
        
        $data['admin_id'] = session('user')['id'];

        // Si le type du post est éducatif, utiliser une URL spécifique
        $url = "/api/blogs/question/create";

        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->post(env('API_SERVICE_URL') . $url, $data);

        if ($response->successful()) {
            $rep = $response->json()['data'];
            Cache::put("question_{$rep['id']}", $response->json()['data'], now()->addMinutes(5));
            Cache::forget("quiz_{$rep['quizzId']}");

        }

        return $this->render($response);
    }

    /**
     * Met à jour un post existant.
     *
     * @param string $id
     * @param array $data
     * @return mixed
     */
    public function update(string $id, array $data) 
    {
        
        $data['admin_id'] = session('user')['id'];

        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->patch(env('API_SERVICE_URL') . "/api/blogs/question/update/" . $id, $data);

        // dd($response)  ;
        
        if ($response->successful()) {
            $rep = $response->json()['data'];
            Cache::put("question_{$rep['id']}", $response->json()['data'], now()->addMinutes(5));
            Cache::forget("quiz_{$rep['quizzId']}");
        }

        return $this->render($response);
    }

    /**
     * Supprime un post via son ID.
     *
     * @param int|string $id
     * @return mixed
     */
    public function delete($id)
    {
        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->delete(env('API_SERVICE_URL') . "/api/blogs/question/delete/" . $id);
        
        if ($response->successful()) {
            Cache::forget("question_{$id}");

        }

        return $this->render($response);
    }
}
