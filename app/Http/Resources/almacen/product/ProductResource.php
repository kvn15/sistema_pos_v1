<?php

namespace App\Http\Resources\almacen\product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'codigo_barras' => $this->resource->codigo_barras,
            'nombre_producto' => $this->resource->nombre_producto,
            'categoria' => $this->resource->categorie->name,
            'stock_inicial' => $this->resource->stock_inicial,
            'stock_limite' => $this->resource->stock_limite,
            'proveedor' => $this->resource->proveedor ? $this->resource->proveedor->razon_social : '',
            'fecha_vencimiento' => $this->resource->fecha_vencimiento,
            'price_compra' => $this->resource->price_compra,
            'imagen_producto' => $this->resource->imagen_producto,
            'price_venta' => $this->resource->product_detail[0]->precio_venta_cantidad,
            'laboratorio' => $this->resource->laboratorio ? $this->resource->laboratorio->laboratorio : '',
            'laboratorio_otro' => $this->resource->laboratorio_otro,
            'marca' => $this->resource->marca ? $this->resource->marca->marca : '',
            'marca_otro' => $this->resource->marca_otro,
            'state' => $this->resource->state,
            'state_name' => $this->resource->state == 1 ? 'Activo' : 'Descativado',
        ];
    }
}
