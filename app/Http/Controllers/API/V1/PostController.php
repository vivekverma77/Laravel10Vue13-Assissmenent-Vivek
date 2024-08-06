<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        return $this->postService->getAllPosts();
    }

    public function store(Request $request)
    {
        $post = $this->postService->createPost($request->all());
        return response()->json($post, 201);
    }

    public function show($id)
    {
        return $this->postService->getPostById($id);
    }

    public function update(Request $request, $id)
    {
        $post = $this->postService->updatePost($id, $request->all());
        return response()->json($post, 200);
    }

    public function destroy($id)
    {
        $this->postService->deletePost($id);
        return response()->json(null, 204);
    }
}
