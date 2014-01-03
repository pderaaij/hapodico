<?php

namespace Hapodico\Service;

/**
 * class for fetching remote content
 *
 * @author pderaaij
 */
class WebContentExtractor {
    
    /**
     * Get the inner content of the requested URL
     * @param string $url
     * @return string|null
     */
    public function grabContent($url) {
        $pageContent = $this->fetchPage($url);
        return $pageContent;
    }

    /**
     * Try to fetch the requested paged of the given url
     * 
     * @param type $url
     * @return type
     */
    private function fetchPage($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $returnData = curl_exec($ch);
        curl_close($ch);
        return $returnData;
    }

}
