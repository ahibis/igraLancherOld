<?
require '../utill.php';
class Dadata {
    private $base_url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest";
    private $token;
    private $handle;
    function __construct($token) {
        $this->token = $token;
    }
    public function init() {
        $this->handle = curl_init();
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->handle, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Token " . $this->token
        ));
        curl_setopt($this->handle, CURLOPT_POST, 1);
    }
    public function suggest($type, $fields)
    {
        $url = $this->base_url . "/$type";
        curl_setopt($this->handle, CURLOPT_URL, $url);
        curl_setopt($this->handle, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($this->handle);
        $result = json_decode($result, true);
        return $result;
    }
    public function close() {
        curl_close($this->handle);
    }
}
// Метод init() следует вызвать один раз в начале,
// затем можно сколько угодно раз вызывать suggest()
// и в конце следует один раз вызвать метод close().
//
// За счёт этого не создаются новые сетевые соединения на каждый запрос,
// а переиспользуется существующее.
$dadata = new Dadata($conf["dataToken"]);
$dadata->init();
$fields = array("query"=>"балаково", "count"=>2);
$result = $dadata->suggest("party", $fields);
echo '<pre>';
print_r($result);
$dadata->close();