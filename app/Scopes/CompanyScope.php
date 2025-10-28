<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CompanyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
          $table = $model->getTable();
        $company_id = session('company_id', null);
        if ($company_id) {
            $builder->where("{$table}.company_id", $company_id);
        }

        // Solo aplica el filtro borrado = 0 si es la tabla 'contacts'
            if ($table === 'contacts') {
                $builder->where("{$table}.borrado", 0);
            }
    }
}
