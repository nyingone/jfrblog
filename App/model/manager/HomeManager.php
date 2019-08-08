<?php
class HomeManager 
{
    private $episodeManager;


    public function __construct($modelName= null,$method= null)
    {    
        $this->episodeManager = new EpisodeManager();
    }

    public function findLastEpisode($level)
    {
        $datas  =   $this->episodeManager->findLast(null, $level);
        return $datas;
    }   
   
}