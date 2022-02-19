<?php

require_once __DIR__.'/../../index.php';

/**
 * @see https://jsonplaceholder.typicode.com/
 */

use Examples\JsonPlaceholder\Endpoints;
use Anomalyce\Interlocutor\{ Interlocutor, Engines };

$interlocutor = new Interlocutor(new Engines\GuzzleHttp);

// GET /posts
print_r((new Endpoints\GetPosts)->send());

// GET /posts/1
// print_r((new Endpoints\GetPost(1))->send());

// GET /posts/1/comments
// print_r((new Endpoints\GetPostComments(post: 1))->send());

// GET /comments
// print_r((new Endpoints\GetComments)->send());

// GET /comments?postid=1
// print_r((new Endpoints\GetComments(post: 1))->send());

// POST /posts
// print_r((new Endpoints\CreatePost('My New Post', 'Lorem ipsum dolor sit amet...'))->send());

// PUT /posts/1
// print_r((new Endpoints\UpdatePost([
//   'id' => 1,
//   'title' => 'My Updated Post',
//   'content' => 'Lorem ipsum dolor sit amet...',
// ]))->send());

// PATCH /posts/1
// print_r((new Endpoints\PatchPost(1, [ 'title' => 'My Updated Post' ]))->send());

// DELETE /posts/1
// print_r((new Endpoints\DeletePost(1))->send());
