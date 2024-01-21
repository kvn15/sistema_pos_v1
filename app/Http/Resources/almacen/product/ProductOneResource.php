<?php

namespace App\Http\Resources\almacen\product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductOneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'tipo_producto_id' => $this->resource->tipo_producto_id,
            'categoria_id' => $this->resource->categoria_id,
            'codigo_barras' => $this->resource->codigo_barras,
            'nombre_producto' => $this->resource->nombre_producto,
            'detalle_producto' => $this->resource->detalle_producto,
            'principio_activo' => $this->resource->principio_activo,
            'marca_id' => $this->resource->marca_id,
            'marca_otro' => $this->resource->marca_otro,
            'provedor_id' => $this->resource->provedor_id,
            'stock_inicial' => $this->resource->stock_inicial,
            'stock_limite' => $this->resource->stock_limite,
            'price_compra' => $this->resource->price_compra,
            'imagen_producto' => $this->resource->imagen_producto,
            'fecha_vencimiento' => $this->resource->fecha_vencimiento,
            'lote' => $this->resource->lote,
            'registro_sanitario' => $this->resource->registro_sanitario,
            'presentacion' => $this->resource->presentacion,
            'tributo_sunat_id' => $this->resource->tributo_sunat_id,
            'laboratorio_id' => $this->resource->laboratorio_id,
            'laboratorio_otro' => $this->resource->laboratorio_otro,
            'state' => $this->resource->state,
            'state_name' => $this->resource->state == 1 ? 'Activo' : 'Descativado',
            'details_product' => $this->resource->product_detail
        ];
    }
}
