<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Salary::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_name' => 'required',
            'days_worked' => 'required|integer',
            'hourly_rate' => 'required|numeric',
            'hours_consumed' => 'required|integer',
        ]);
    
        $salary = new Salary();
        $salary->user_name = $request->user_name;
        $salary->days_worked = $request->days_worked;
        $salary->hourly_rate = $request->hourly_rate;
        $salary->hours_consumed = $request->hours_consumed;
        $salary->total = $salary->hourly_rate * $salary->hours_consumed;
        $salary->save();
    
        return response()->json($salary);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $salary = Salary::find($id);

        if ($salary) {
            return response()->json($salary);
        } else {
            return response()->json(['message' => 'Salário não encontrado'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validação dos dados de entrada
        $validated = $request->validate([
            'user_name' => 'required',
            'days_worked' => 'required|integer',
            'hourly_rate' => 'required|numeric',
            'hours_consumed' => 'required|integer',
        ]);

        // Encontrar o registro de salário a ser atualizado
        $salary = Salary::find($id);

        if (!$salary) {
            return response()->json(['message' => 'Salário não encontrado'], 404);
        }

        // Atualizar os campos com novos valores
        $salary->user_name = $request->user_name;
        $salary->days_worked = $request->days_worked;
        $salary->hourly_rate = $request->hourly_rate;
        $salary->hours_consumed = $request->hours_consumed;
        // Recalcular o total com base nos novos valores
        $salary->total = $salary->hourly_rate * $salary->hours_consumed;

        // Salvar as alterações no banco de dados
        $salary->save();

        return response()->json($salary);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Encontrar o registro de salário pelo ID
        $salary = Salary::find($id);

        if (!$salary) {
            return response()->json(['message' => 'Salário não encontrado'], 404);
        }

        // Deletar o registro do banco de dados
        $salary->delete();

        return response()->json(['message' => 'Registro de salário excluído com sucesso']);
    }
}
