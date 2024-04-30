<?php
namespace Kiboko\FattureCloud;

class FattureCloud
{

    protected static function auth( $auth = null )
    {
        if ($auth)
        {
            return $auth;
        }
        else
        {
            return [
                'api_uid' => env('FC_UID', '00000'),
                'api_key' => env('FC_KEY', '00000')
            ];
        }
    }

    public static function setRequestMetod($method = null)
    {
        $valid = [
            'PUT', 'POST', 'GET', 'HEAD', 'DELETE', 'OPTIONS'
        ];
        
        if($method && in_array($method,$valid)) return $method;
    }

    public static function doRequest($endpoint = 'richiesta/info', $data = [])
    {
        $auth = self::auth();
        
        $response = null;
        $data = ($data) ? $data : [];
        try {
            $params = array_merge($auth,$data);
            $url = implode("/", [env('FC_BASE_URL', 'https://api.fattureincloud.it:443'), env('FC_API_VERSION', 'v1')]) . '/' . $endpoint;
            $options = array(
                "http" => array(
                    "header"  => "Content-type: text/json\r\n",
                    "method"  => "POST",
                    "content" => json_encode($params)
                ),
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            return self::parseResponse($result);
        }
        catch(ClientException $clientException) {
            switch ($clientException->getResponse()->getStatusCode()) {
                case '404':
                    return json_encode([
                        'error' => "Endpoint non esistente",
                        'error_code' => "404"
                    ]);
                    break;
            }
        }

    }

    protected static function parseResponse($response)
    {
        if(self::isResponseValid($response)) return $response;
        else {
            return json_encode([
                'error' => "Non riesco a leggere la risposta",
                'error_code' => "500"
            ]);
        }
    }

    private static function isResponseValid($string)
    {
        json_decode($string,true);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * GENERICHE
     **/

    public static function doRichiestaInfo($data = []) {
        return self::doRequest('richiesta/info', $data);
    }

    public static function doInfo($data = []) {
        return self::doRequest('mail/lista', $data);
    }


    /**
     * ANAGRAFICA - CLIENTI
     **/

    public static function doClientiLista($data = []) {
        return self::doRequest('clienti/lista', $data);
    }

    public static function doClientiNuovo($data = []) {
        return self::doRequest('clienti/nuovo', $data);
    }

    public static function doClientiImporta($data = []) {
        return self::doRequest('clienti/importa', $data);
    }

    public static function doClientiModifica($data = []) {
        return self::doRequest('clienti/modifica', $data);
    }

    public static function doClientiElimina($data = []) {
        return self::doRequest('clienti/elimina', $data);
    }


    /**
     * ANAGRAFICA - FORNITORI
     **/

    public static function doFornitoriLista($data = []) {
        return self::doRequest('fornitori/lista', $data);
    }

    public static function doFornitoriNuovo($data = []) {
        return self::doRequest('fornitori/nuovo', $data);
    }

    public static function doFornitoriImporta($data = []) {
        return self::doRequest('fornitori/importa', $data);
    }

    public static function doFornitoriModifica($data = []) {
        return self::doRequest('fornitori/modifica', $data);
    }

    public static function doFornitoriElimina($data = []) {
        return self::doRequest('fornitori/elimina', $data);
    }


    /**
     * PRODOTTI
     **/

    public static function doProdottiLista($data = []) {
        return self::doRequest('prodotti/lista', $data);
    }

    public static function doProdottiNuovo($data = []) {
        return self::doRequest('prodotti/nuovo', $data);
    }

    public static function doProdottiImporta($data = []) {
        return self::doRequest('prodotti/importa', $data);
    }

    public static function doProdottiModifica($data = []) {
        return self::doRequest('prodotti/modifica', $data);
    }

    public static function doProdottiElimina($data = []) {
        return self::doRequest('prodotti/elimina', $data);
    }


    /**
     * DOCUMENTI EMESSI - FATTURE
     **/

    public static function doFattureLista($data = []) {
        return self::doRequest('fatture/lista', $data);
    }

    public static function doFattureDettagli($data = []) {
        return self::doRequest('fatture/dettagli', $data);
    }

    public static function doFattureNuovo($data = []) {
        return self::doRequest('fatture/nuovo', $data);
    }

    public static function doFattureModifica($data = []) {
        return self::doRequest('fatture/modifica', $data);
    }

    public static function doFattureElimina($data = []) {
        return self::doRequest('fatture/elimina', $data);
    }

    public static function doFattureInfo($data = []) {
        return self::doRequest('fatture/info', $data);
    }


    /**
     * DOCUMENTI EMESSI - PROFORMA
     **/

    public static function doProformaLista($data = []) {
        return self::doRequest('proforma/lista', $data);
    }

    public static function doProformaDettagli($data = []) {
        return self::doRequest('proforma/dettagli', $data);
    }

    public static function doProformaNuovo($data = []) {
        return self::doRequest('proforma/nuovo', $data);
    }

    public static function doProformaModifica($data = []) {
        return self::doRequest('proforma/modifica', $data);
    }

    public static function doProformaElimina($data = []) {
        return self::doRequest('proforma/elimina', $data);
    }

    public static function doProformaInfo($data = []) {
        return self::doRequest('proforma/info', $data);
    }

    /**
     * DOCUMENTI EMESSI - ORDINI
     **/

    public static function doOrdiniLista($data = []) {
        return self::doRequest('ordini/lista', $data);
    }

    public static function doOrdiniDettagli($data = []) {
        return self::doRequest('ordini/dettagli', $data);
    }

    public static function doOrdiniNuovo($data = []) {
        return self::doRequest('ordini/nuovo', $data);
    }

    public static function doOrdiniModifica($data = []) {
        return self::doRequest('ordini/modifica', $data);
    }

    public static function doOrdiniElimina($data = []) {
        return self::doRequest('ordini/elimina', $data);
    }

    public static function doOrdiniInfo($data = []) {
        return self::doRequest('ordini/info', $data);
    }

    /**
     * DOCUMENTI EMESSI - ORDINI
     **/

    public static function doPreventiviLista($data = []) {
        return self::doRequest('preventivi/lista', $data);
    }

    public static function doPreventiviDettagli($data = []) {
        return self::doRequest('preventivi/dettagli', $data);
    }

    public static function doPreventiviNuovo($data = []) {
        return self::doRequest('preventivi/nuovo', $data);
    }

    public static function doPreventiviModifica($data = []) {
        return self::doRequest('preventivi/modifica', $data);
    }

    public static function doPreventiviElimina($data = []) {
        return self::doRequest('preventivi/elimina', $data);
    }

    public static function doPreventiviInfo($data = []) {
        return self::doRequest('preventivi/info', $data);
    }


    /**
     * DOCUMENTI EMESSI - Note Di Credito
     **/

    public static function doNdcLista($data = []) {
        return self::doRequest('ndc/lista', $data);
    }

    public static function doNdcDettagli($data = []) {
        return self::doRequest('ndc/dettagli', $data);
    }

    public static function doNdcNuovo($data = []) {
        return self::doRequest('ndc/nuovo', $data);
    }

    public static function doNdcModifica($data = []) {
        return self::doRequest('ndc/modifica', $data);
    }

    public static function doNdcElimina($data = []) {
        return self::doRequest('ndc/elimina', $data);
    }

    public static function doNdcInfo($data = []) {
        return self::doRequest('ndc/info', $data);
    }


    /**
     * DOCUMENTI EMESSI - RICEVUTE
     **/

    public static function doRicevuteLista($data = []) {
        return self::doRequest('ricevute/lista', $data);
    }

    public static function doRicevuteDettagli($data = []) {
        return self::doRequest('ricevute/dettagli', $data);
    }

    public static function doRicevuteNuovo($data = []) {
        return self::doRequest('ricevute/nuovo', $data);
    }

    public static function doRicevuteModifica($data = []) {
        return self::doRequest('ricevute/modifica', $data);
    }

    public static function doRicevuteElimina($data = []) {
        return self::doRequest('ricevute/elimina', $data);
    }

    public static function doRicevuteInfo($data = []) {
        return self::doRequest('ricevute/info', $data);
    }


    /**
     * DOCUMENTI EMESSI - DDT
     **/

    public static function doDdtLista($data = []) {
        return self::doRequest('ddt/lista', $data);
    }

    public static function doDdtDettagli($data = []) {
        return self::doRequest('ddt/dettagli', $data);
    }

    public static function doDdtNuovo($data = []) {
        return self::doRequest('ddt/nuovo', $data);
    }

    public static function doDdtModifica($data = []) {
        return self::doRequest('ddt/modifica', $data);
    }

    public static function doDdtElimina($data = []) {
        return self::doRequest('ddt/elimina', $data);
    }

    public static function doDdtInfo($data = []) {
        return self::doRequest('ddt/info', $data);
    }

    /**
     * ACQUISTI
     **/

    public static function doAcquistiLista($data = []) {
        return self::doRequest('acquisti/lista', $data);
    }

    public static function doAcquistiDettagli($data = []) {
        return self::doRequest('acquisti/dettagli', $data);
    }

    /**
     * MAIL
     **/

    public static function doMailLista($data = []) {
        return self::doRequest('mail/lista', $data);
    }
}