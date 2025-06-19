<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;

class CommentController extends Controller
{
    protected $client;
    protected $baseUri = 'http://fastapi:8001';

    public function __construct()
    {
        $this->client = new Client(['base_uri' => $this->baseUri]);
    }

    public function showForm()
    {
        return view('comment');
    }

    public function analyzeComment(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        try {
            $response = $this->client->post('/analyze-sentiment/', [
                'json' => ['text' => $request->comment],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            return view('comment', [
                'comment' => $request->comment,
                'sentiment' => $result['label'],
                'score' => number_format($result['score'], 2),
            ]);
        } catch (ConnectException $e) {
            return view('comment', [
                'error' => 'Unable to connect to the sentiment analysis service. Please try again later.',
                'comment' => $request->comment,
            ]);
        } catch (RequestException $e) {
            $errorMessage = 'An error occurred while analyzing the comment.';
            if ($e->hasResponse()) {
                $statusCode = $e->getResponse()->getStatusCode();
                if ($statusCode === 400) {
                    $errorMessage = 'Invalid comment format. Please check your input.';
                } elseif ($statusCode === 500) {
                    $errorMessage = 'Sentiment analysis service encountered an internal error.';
                }
            }
            return view('comment', [
                'error' => $errorMessage,
                'comment' => $request->comment,
            ]);
        }
    }
}