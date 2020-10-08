<?php


namespace App\Sepomex;


use App\CargaLayout;
use App\Contracts\IUploadLayoutCp;
use App\CpSepomex;
use Exception;
use PHPExcel_IOFactory;

class ReadLayoutSepomex implements IUploadLayoutCp
{
    /** @var CargaLayout $carga_layout_id */
    protected $carga_layout_id;

    /**
     * ReadLayoutSepomex constructor.
     * @param $carga_layout_id
     */
    public function __construct(CargaLayout $carga_layout_id)
    {
        $this->carga_layout_id = $carga_layout_id;
    }

    /**
     * @param $file
     * @return mixed|void
     * @throws Exception
     */
    public function readLayout($file)
    {
        try {
            $inputFileType = PHPExcel_IOFactory::identify($file);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($file);
            $count_sheets = count($objPHPExcel->getAllSheets());
            $count_registros = 0;
            for ($j = 1; $j < $count_sheets; $j++) {
                unset($d_codigo,$data);
                $data = [];
                $totaDeFilasConceptos = $objPHPExcel->setActiveSheetIndex($j)->getHighestRow();
                for ($i = 2; $i <= $totaDeFilasConceptos; $i++) {
                    $data['d_codigo']         = $objPHPExcel->setActiveSheetIndex($j)->getCell('A' . $i)->getValue();
                    $data['d_asenta']         = $objPHPExcel->setActiveSheetIndex($j)->getCell('B' . $i)->getValue();
                    $data['d_tipo_asenta']    = $objPHPExcel->setActiveSheetIndex($j)->getCell('C' . $i)->getValue();
                    $data['d_mnpio']          = $objPHPExcel->setActiveSheetIndex($j)->getCell('D' . $i)->getValue();
                    $data['d_estado']         = $objPHPExcel->setActiveSheetIndex($j)->getCell('E' . $i)->getValue();
                    $data['d_ciudad']         = $objPHPExcel->setActiveSheetIndex($j)->getCell('F' . $i)->getValue();
                    $data['cp']               = $objPHPExcel->setActiveSheetIndex($j)->getCell('G' . $i)->getValue();
                    $data['c_estado']         = $objPHPExcel->setActiveSheetIndex($j)->getCell('H' . $i)->getValue();
                    $data['c_oficina']        = $objPHPExcel->setActiveSheetIndex($j)->getCell('I' . $i)->getValue();
                    $data['c_cp']             = $objPHPExcel->setActiveSheetIndex($j)->getCell('J' . $i)->getValue();
                    $data['c_tipo_asenta']    = $objPHPExcel->setActiveSheetIndex($j)->getCell('K' . $i)->getValue();
                    $data['c_mnpio']          = $objPHPExcel->setActiveSheetIndex($j)->getCell('L' . $i)->getValue();
                    $data['id_asenta_cpcons'] = $objPHPExcel->setActiveSheetIndex($j)->getCell('M' . $i)->getValue();
                    $data['d_zona']           = $objPHPExcel->setActiveSheetIndex($j)->getCell('N' . $i)->getValue();
                    $data['c_cve_ciudad']     = $objPHPExcel->setActiveSheetIndex($j)->getCell('O' . $i)->getValue();
                    $data['carga_layout_id']  = $this->carga_layout_id->id;
                    $this->saveInformation($data);
                    $count_registros++;
                    $this->carga_layout_id->num_data_inserted = $count_registros++;
                    $this->carga_layout_id->save();
                }
            }
        }catch(Exception $e){
            throw new Exception("Existio un problema al cargar layout",$e->getMessage());
        }
    }

    /**
     * @param array $information
     * @return mixed|void
     * @throws Exception
     */
    public function saveInformation(array $information)
    {
        try {
            CpSepomex::create($information);
        }catch(Exception $e){
            throw new Exception("Existio un problema en el guardado de la información",$e->getMessage());
        }
    }
}
