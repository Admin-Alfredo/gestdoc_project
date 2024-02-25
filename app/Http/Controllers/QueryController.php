<?php

namespace App\Http\Controllers;

use App\Models\Cidadao;
use Illuminate\Database\Eloquent\Builder as BuilderQueryDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

function buildQueryData(BuilderQueryDate $query, string $data, array $fields): void
{

    $splitDate = explode('-', $data);
    /**field to filter */
    switch ($fields[1]) {
        case 'DAY':
            $query->whereDay($fields[0], "=", $splitDate[2]);
            break;
        case 'MONTH':
            $query->whereMonth($fields[0], "=", $splitDate[1]);
            break;
        case 'YEAR':
            $query->whereYear($fields[0], "=", $splitDate[0]);
            break;
        case 'DAY_MONTH':
            $query->whereDay($fields[0], "=", $splitDate[2])
                ->whereMonth($fields[0], "=", $splitDate[1]);
            break;
        case 'MONTH_YEAR':
            $query->whereMonth($fields[0], "=", $splitDate[1])
                ->whereYear($fields[0], "=", $splitDate[0]);
            break;
        case 'DAY_YEAR':
            $query->whereDay($fields[0], "=", $splitDate[2])
                ->whereYear($fields[0], "=", $splitDate[0]);
            break;
        case 'FULL':
            $query->whereDate('data_nascimento', "=", $data);
            break;
    }
}

function buildAdvancedQueryData(BuilderQueryDate $query, array $fields, array $labels)
{

    $dataInitialSplit = explode('-', $fields[0]);
    $dataFinalSplit = explode('-', $fields[1]);
    switch ($fields[2]) {
        case 'MONTH':
            $query->whereBetween(DB::raw("MONTH(" . $labels[0] . ")"), [$dataInitialSplit[1], $dataFinalSplit[1]]);
            // dd($query->toSql(),  [$dataInitialSplit[1], $dataFinalSplit[1]]);
            break;
        case 'YEAR':
            $query->whereBetween(DB::raw("YEAR(" . $labels[0] . ")"), [$dataInitialSplit[0], $dataFinalSplit[0]]);
            // dd($query->toSql(),  [$dataInitialSplit[0], $dataFinalSplit[0]]);
            break;
    }
}

class QueryController extends Controller
{
    public function index(Request $req)
    {
        $query = Cidadao::query();
        $query->limit($req->input('limit'));

        if ($req->has("nome")) {
            switch ($req->input('nome_tq')) {
                case 'OR':
                    $query->where('nome', 'LIKE', "%" . $req->input('nome') . "%");
                    break;
                case 'AND':
                    $query->where('nome', '=',  $req->input('nome'));
                    break;
            }
        }
        if ($req->has('n_bi')) {
            $query->where('n_bi', "=", $req->input('n_bi'));
        }
        if ($req->has('data_nac_intl') && $req->input('data_nac_intl') == 'ON' && $req->has('data_nascimento') && $req->has('data_nascimento_last')) {
            buildAdvancedQueryData(
                $query,
                [
                    $req->input('data_nascimento'),
                    $req->input('data_nascimento_last'),
                    $req->input('data_n_tq')
                ],
                ['data_nascimento', 'data_nascimento_last']
            );
        } else if ($req->has('data_nascimento')) {
            buildQueryData(
                $query,
                $req->input('data_nascimento'),
                ['data_nascimento', $req->input('data_n_tq')]
            );
        }

        if ($req->has('nacionalidade')) {
            $query->where('nacionalidade', '=', $req->input('nacionalidade'));
        }
        if ($req->has('nome_mae')) {
            switch ($req->input('nome_m_tq')) {
                case 'OR':
                    $query->where('nome_mae', 'LIKE', "%" . $req->input('nome_mae') . "%");
                    break;
                case 'AND':
                    $query->where('nome_mae', '=',  $req->input('nome_mae'));
                    break;
            }
        }

        if ($req->has('nome_pai')) {
            switch ($req->input('nome_p_tq')) {
                case 'OR':
                    $query->where('nome_pai', 'LIKE', "%" . $req->input('nome_pai') . "%");
                    break;
                case 'AND':
                    $query->where('nome_pai', '=',  $req->input('nome_pai'));
                    break;
            }
        }
        if ($req->has('data_ck_intl') && $req->input('data_ck_intl') == 'ON' && $req->has('data_bi_emissao') && $req->has('data_bi_validade')) {
            buildAdvancedQueryData(
                $query,
                [
                    0 => $req->input('data_bi_emissao'),
                    1 => $req->input('data_bi_validade'),
                    2 => $req->input('data_bie_tq'),
                ],
                [0 => 'data_bi_emissao', 1 => 'data_bi_validade']
            );
        } else {
            if ($req->has('data_bi_emissao')) {
                buildQueryData(
                    $query,
                    $req->input('data_bi_emissao'),
                    ['data_bi_emissao', $req->input('data_bie_tq')]
                );
            }
            if ($req->has('data_bi_validade')) {
                buildQueryData(
                    $query,
                    $req->input('data_bi_validade'),
                    ['data_bi_validade', $req->input('data_biv_tq')]
                );
            }
        }



        if ($req->has('estado_civil')) {
            $query->where('estado_civil', '=', $req->input('estado_civil'));
        }
        if ($req->has('altura')) {
            $query->where('altura', '=', $req->input('altura'));
        }
        // if ($req->has('residencia')) {
        //     $query->where('residencia', '=', $req->input('residencia'));
        // }
        if ($req->has('provincia')) {
            $query->where('provincia', '=', $req->input('provincia'));
        }
        if ($req->has('sexo')) {
            $query->where('sexo', '=', $req->input('sexo'));
        }


        if ($query->getQuery()->wheres) {
            $cidadao = $query->get();
        } else {
            $cidadao = [];
        }
        return response()->json(['cidadoes' => $cidadao]);
    }
    function getStatist()
    {
        $query = Cidadao::query();
        $statistic = $query->count();
        return response()->json(['statistic' => $statistic]);
    }
}
