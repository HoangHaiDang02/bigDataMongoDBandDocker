<?php

namespace App\Http\Controllers;

use App\MongoDb\MongoRepositorisService\InfrastructureService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use MongoDate;

class MongoDBController extends Controller
{
    /**
     * @var string
     */
    private string $collectName  = 'collectData';

    /**
     * @var InfrastructureService
     */
    private InfrastructureService $connectCollection;

    public function __construct()
    {
        $this->connectCollection = new InfrastructureService($this->collectName);
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->connectCollection->getAllValue();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insertValue(Request $request)
    {
        $validate = Validator::make($request->all(), $this->validateData());
        if (!empty($validate->errors())) {
            $data = $validate->getData();
            try {
                $values = array_values($data);
                $commaSeparatedValues = implode(",", $values);
                $dataInsertToFile = $commaSeparatedValues . "\n";
                $test = "/home/danghh/demo/bigDataMongoDBandDocker/bigData/datainrequest.txt";

                $file = fopen($test,'w');
                fwrite($file, $dataInsertToFile);
                fclose($file);
                shell_exec("/bin/python3 /home/danghh/demo/bigDataMongoDBandDocker/bigData/pythonMLP/handleModel.py");

                $dataAfterPredictContent = file_get_contents("/home/danghh/demo/bigDataMongoDBandDocker/bigData/outputdata.txt","r");
                $dataAfterPredict = str_replace("\n", "",$dataAfterPredictContent);

                $this->connectCollection->insertValuesToCollection(
                    $this->mergeDataInField(
                        explode(",",$dataAfterPredict)
                    )
                );


                return response()->json([
                    'success' => true,
                    'descriptionHandle' => 'Created data in mongodb',
                    'resultPredict' => $this->readResult()
                ]);
            } catch (\Throwable $exception) {
                return response()->json([
                    'success' => false,
                    'message' => $exception->getMessage()
                ]);
            }
        }
        return response()->json([
            'success' => false,
            'message' => $validate->errors()
        ]);
    }

    /**
     * @return string[]
     */
    private function validateData(): array
    {
        return [
            'toan1' => 'required|numeric',
            'ly1' => 'required|numeric',
            'hoa1' => 'required|numeric',
            'sinh1' => 'required|numeric',
            'van1' => 'required|numeric',
            'su1' => 'required|numeric',
            'dia1' => 'required|numeric',
            'anh1' => 'required|numeric',
            'toan2' => 'required|numeric',
            'ly2' => 'required|numeric',
            'hoa2' => 'required|numeric',
            'sinh2' => 'required|numeric',
            'van2' => 'required|numeric',
            'su2' => 'required|numeric',
            'dia2' => 'required|numeric',
            'anh2' => 'required|numeric'
        ];
    }

    /**
     * @param $data
     * @return array
     */
    private function mergeDataInField($data): array
    {
        return [
            'toan1' => $data[0],
            'ly1' => $data[1],
            'hoa1' => $data[2],
            'sinh1' => $data[3],
            'van1' => $data[4],
            'su1' => $data[5],
            'dia1' => $data[6],
            'anh1' => $data[7],
            'toan2' => $data[8],
            'ly2' => $data[9],
            'hoa2' => $data[10],
            'sinh2' => $data[11],
            'van2' => $data[12],
            'su2' => $data[13],
            'dia2' => $data[14],
            'anh2' => $data[15],
            'label' => $data[16],
            "time_upload" => new \MongoDB\BSON\UTCDateTime()
        ];
    }


    public function syncDataInToDataTrain()
    {
        $allData = $this->connectCollection->getAllValue();
        foreach ($allData as $value) {
            $this->connectCollection->deleteData($value['_id']);
            unset($value['_id'], $value['time_upload']);
            $insertInToDataSave = new InfrastructureService('collectDataSaveModal');
            $insertInToDataSave->insertValuesToCollection($value);

            $values = array_values($value);
            $commaSeparatedValues = implode(",", $values);
            $dataInsertToFile = $commaSeparatedValues . "\n";
            $test = "/home/danghh/demo/bigDataMongoDBandDocker/bigData/pythonMLP/test_2.csv";

            $file = fopen($test,'a');
            fwrite($file, $dataInsertToFile);
            fclose($file);
        }
        shell_exec("/bin/python3 /home/danghh/demo/bigDataMongoDBandDocker/bigData/pythonMLP/mlp.py");
        return response()->json([
            'success' => true,
            'message' => 'Trained new modal with new Data'
        ]);
    }

    /**
     * @return string
     */
    public function readResult(): string
    {
        $result = 0;
        $predict = '';
        $filePath = '/home/danghh/demo/bigDataMongoDBandDocker/bigData/pythonMLP/predict.txt';
        $readFile = fopen($filePath,'r');
        while(! feof($readFile)) {
            $result = fgets(($readFile));
        }

        switch ((int)$result) {
            case 0:
                $predict = 'A00';
                break;
            case 1:
                $predict = 'A01';
                break;
            case 2:
                $predict = 'B00';
                break;
            case 3:
                $predict = 'B08';
                break;
            case 4:
                $predict = 'C00';
                break;
            default:
                $predict = 'D00';
        }

        return (string) $predict;
    }
}

