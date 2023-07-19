<?php

namespace App\Models;
use App\Database\DB;

use PDO;

class Categoria
{
    private int $categoriaId;
    private string $categoriaNombre;

    // Método para cargar los datos de un array en la instancia de la clase
    public function cargarDatosDeArray(array $data): void
    {
        $this->setCategoriaId($data['categoria_id']);
        $this->setCategoriaNombre($data['categoria_nombre']);
    }

    // Método para obtener todas las categorías
    public function todos(): array
    {
        $db = DB::getConexion();
        $query = "SELECT * FROM categorias";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $categorias = [];

        while ($registro = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categoria = new Categoria();
            $categoria->cargarDatosDeArray($registro);
            $categorias[] = $categoria;
        }

        return $categorias;
    }

    public static function categoriaPorId(int $id): ?Categoria
    {
        $db = DB::getConexion();
        $query = "SELECT categoria_id, categoria_nombre FROM categorias WHERE categoria_id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($registro) {
            $categoria = new Categoria();
            $categoria->cargarDatosDeArray($registro);
            return $categoria;
        } else {
            return null;
        }
    }

    // Getter para categoriaId
    public function getCategoriaId(): int
    {
        return $this->categoriaId;
    }

    // Setter para categoriaId
    public function setCategoriaId(int $categoriaId): void
    {
        $this->categoriaId = $categoriaId;
    }

    // Getter para categoriaNombre
    public function getCategoriaNombre(): string
    {
        return $this->categoriaNombre;
    }

    // Setter para categoriaNombre
    public function setCategoriaNombre(string $categoriaNombre): void
    {
        $this->categoriaNombre = $categoriaNombre;
    }
}