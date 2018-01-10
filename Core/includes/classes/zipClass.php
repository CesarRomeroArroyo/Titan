<?php
Class zipper
{
    public static function Descomprime($ruta,$nombreArchivo)
    {        
        try
        {
            $zip = new ZipArchive;
            $res = $zip->open($ruta."/".$nombreArchivo);
             
            if ($res === TRUE) {

             $zip->extractTo($ruta);
             return $ruta."/".$nombreArchivo."Desceomprime";
             $zip->close();
            } else {
             return $ruta."/".$nombreArchivo."No descomprime";
            }
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }
    
    public static function Comprimir($rutaZip, $nombreArchivoZip, $rutaArchivo, $nombreArchivo)
    {
        $zip = new ZipArchive;
        $res = $zip->open($rutaZip.'/'.$nombreArchivoZip, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
        if ($res === TRUE) {            
            $zip->addFile($rutaArchivo.'/'. $nombreArchivo, $nombreArchivo);           
            $zip->close();
            return true;
        } else {
            return false;
        }
    }
    
    public static function ComprimirVarios($rutaZip, $nombreArchivoZip, $rutaArchivo, $nombreArchivo)
    {
        $zip = new ZipArchive;
        $res = $zip->open($rutaZip.'/'.$nombreArchivoZip, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
        if ($res === TRUE) {            
            for($i=0;$i<count($nombreArchivo);$i++)
            {
                $zip->addFile($rutaArchivo.'/'. $nombreArchivo[$i], $nombreArchivo[$i]);           
            }
            $zip->close();
            return true;
        } else {
            return false;
        }
    }
    
    


   
}

?>
