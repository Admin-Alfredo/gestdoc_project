<?php

namespace App\Http\Controllers;

use App\Models\Cidadao;
use Illuminate\Database\Eloquent\Builder as BuilderQueryDate;
use Illuminate\Http\Request;


function getQueryData(BuilderQueryDate $query, string $data, array $fields): void
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
        if ($req->has('data_nascimento')) {
            getQueryData(
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
        if ($req->has('data_bi_emissao')) {
            getQueryData(
                $query,
                $req->input('data_bi_emissao'),
                ['data_bi_emissao', $req->input('data_bie_tq')]
            );
        }
        if ($req->has('data_bi_validade')) {
            getQueryData(
                $query,
                $req->input('data_bi_validade'),
                ['data_bi_validade', $req->input('data_biv_tq')]
            );
        }

        if ($req->has('estado_civil')) {
            $query->where('estado_civil', '=', $req->input('estado_civil'));
        }
        if ($req->has('altura')) {
            $query->where('altura', '=', $req->input('altura'));
        }
        if ($req->has('residencia')) {
            $query->where('residencia', '=', $req->input('residencia'));
        }
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
    function getStatist()  {
        $query = Cidadao::query();
        $statistic = $query->count();
        return response()->json(['statistic' => $statistic]);
    }
}
