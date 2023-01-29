<?php

namespace App\Traits;

trait Destroyable
{
    public function destroy($entity, $id)
    {
        $model = app("App\Models\\$entity");
        $row = $model::find($id);
        $row->delete();

        $this->emit('alert', [
            'type' => 'success',
            'message' => 'Excluído com sucesso!',
        ]);
    }
}
