<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class QuizService
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
            ->get(env('API_SERVICE_URL') . '/api/blogs/quizz', $params);

        if ($response->successful()) {
            return collect($response->json()['data']);
        }

        throw new \Exception('Erreur lors de la récupération des posts');
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

        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->get(env('API_SERVICE_URL') . '/api/blogs/quizz/' . $id, $params);

        if ($response->successful()) {
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
        $url = "/api/blogs/quizz/create";

        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->post(env('API_SERVICE_URL') . $url, $data);

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
            ->patch(env('API_SERVICE_URL') . "/api/blogs/quizz/update/" . $id, $data);

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
            ->delete(env('API_SERVICE_URL') . "/api/blogs/quizz/delete/" . $id);

        return $this->render($response);
    }
}
