<?php

namespace Hapodico\Service;

/**
 * Service class providing the availble clubs on the handbal.nl website.
 *
 * @author pderaaij
 */
class ClubProviderService {
    
    const TEAM_OVERVIEW_PAGE = 'http://www.handbal.nl/ajax/competition/show_clubs_overview/';
    const TEAM_PAGE_BASE = 'http://www.handbal.nl/ajax/competition/show_club_teams/';
    
    /**
     * 
     * @return type
     */
    public function fetchClubs() {
        $extractor = new WebContentExtractor();
        $content = $extractor->grabContent(self::TEAM_OVERVIEW_PAGE);
        
        if ($content === null) {
            return array();
        }
        
        return $this->extractClubs($content);
    }
    
    /**
     * 
     * @param type $code The club identifier
     */
    public function fetchTeams($code) {
        $extractor = new WebContentExtractor();
        $content = $extractor->grabContent(self::TEAM_PAGE_BASE . $code . '/');
        
        if ($content === null) {
            return array();
        }
        
        return $this->extractTeams($content);
    }

    /**
     * 
     * @param type $content
     * @return type
     */
    private function extractClubs($content) {
        $mapping = array();
        $haystack = $this->cleanHaystack($content);
        
        $dom = new \DomDocument();
        $dom->loadHTML($haystack);
        $urls = $dom->getElementsByTagName('a');
        foreach ($urls as $url) {
            $mapping[$url->getAttribute('rel')] = trim($url->nodeValue);
        }
        
        return $mapping;
    }
    
    /**
     * 
     * @param type $content
     * @return type
     */
    private function extractTeams($content) {
        $mapping = array();
        $haystack = $this->cleanHaystack($content);
        
        $dom = new \DomDocument();
        $dom->loadHTML($haystack);
        $urls = $dom->getElementsByTagName('a');
        foreach ($urls as $url) {
            $mapping[$url->getAttribute('rel')] = trim($url->nodeValue);
        }
        
        natcasesort($mapping);
        return $mapping;
    }
    
    /**
     * 
     * @param type $content
     * @return type
     */
    private function cleanHaystack($content) {
        $haystack = strip_tags($content, '<a>');
        return preg_replace('/\s+/', ' ', $haystack);
    }

}
