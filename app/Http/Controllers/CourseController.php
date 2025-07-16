<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Lista todos os cursos, incluindo os dados do usuário criador.
     */
    public function index()
    {
        return response()->json(Course::with('user')->get());
    }

    /**
     * Cria um novo curso.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'        => ['required', 'string', 'max:255', Rule::unique('courses')],
            'description' => ['nullable', 'string'],
            'duration'    => ['required', 'integer', 'min:1'],
            'price'       => ['required', 'numeric', 'min:0'],
        ]);

        $validatedData['user_id'] = auth()->id();

        $course = Course::create($validatedData);

        return response()->json($course, 201);
    }

    /**
     * Exibe um curso específico.
     */
    public function show(Course $course)
    {
        $course->load('user');
        return response()->json($course);
    }

    /**
     * Atualiza um curso específico.
     */
    public function update(Request $request, Course $course)
    {

        $validatedData = $request->validate([
            'name'        => ['sometimes', 'string', 'max:255', Rule::unique('courses')->ignore($course->id)],
            'description' => ['sometimes', 'nullable', 'string'],
            'duration'    => ['sometimes', 'integer', 'min:1'],
            'price'       => ['sometimes', 'numeric', 'min:0'],
        ]);

        $course->update($validatedData);

        return response()->json($course);
    }

    /**
     * Remove um curso específico.
     */
    public function destroy(Course $course)
    {
        // $this->authorize('delete', $course);

        $course->delete();

        return response()->json(null, 204);
    }
}