<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Document;
use App\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Document as DocumentResource;

class DocumentController extends Controller
{
    public function index()
    {
        return DocumentResource::collection(Document::all());
    }

    public function show(Document $document)
    {
        return new DocumentResource($document);
    }

    public function update(Document $document, Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($request->file('file')) {
            $allowedTypes = [
                'image/png',
                'image/jpeg',
                'image/gif'
            ];
            if (!in_array($request->file('file')->getClientMimeType(), $allowedTypes)) {
                return response()->json([
                    'message' => 'File not supported'
                ], 401);
            }
        }

        $document->update($data);

        if ($request->file('file')) {
            // удалить старый файл
            $file = File::where('document_id', $document->id)->first();
            if ($file) {
                Storage::delete($file->path);
                $file->delete();
            }
            $path = $request->file('file')->store('files');
            $file = new File;
            $file->filename = $request->file('file')->getClientOriginalName();
            $file->path = $path;
            $file->size = $request->file('file')->getSize();
            $file->document_id = $document->id;
            $file->save();
        }

        return new DocumentResource($document);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($request->file('file')) {
            $allowedTypes = [
                'image/png',
                'image/jpeg',
                'image/gif'
            ];
            if (!in_array($request->file('file')->getClientMimeType(), $allowedTypes)) {
                return response()->json([
                    'message' => 'File not supported'
                ], 401);
            }
        }

        $document = Document::create($data);

        if ($request->file('file')) {
            $path = $request->file('file')->store('files');
            $file = new File;
            $file->filename = $request->file('file')->getClientOriginalName();
            $file->path = $path;
            $file->size = $request->file('file')->getSize();
            $file->document_id = $document->id;
            $file->save();
        }

        return new DocumentResource($document);
    }

    public function destroy(Document $document)
    {
        $file = File::where('document_id', $document->id)->first();
        if ($file) {
            Storage::delete($file->path);
            $file->delete();
        }

        $document->delete();

        return response(null, 204);
    }
}
