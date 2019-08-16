<?php
class HomeManager 
{
    private $_episodeManager;
    private $_bookManager;
    private $_level = 'N1';


    public function __construct($modelName= null,$method= null)
    {    
        $this->_episodeManager = new EpisodeManager();
        $this->_bookManager = new BookManager();
    }

    /* 
    * Récup dernier épisode via Episode Manager
    * @param string ($level )
    */
    public function findLastEpisode($level)
    {
        $datas  =   $this->_episodeManager->findLast(null, $level);
        return $datas;
    }   

    public function findAboutJFR()
    {
        $datas  =   $this->_episodeManager->findAboutJFR(null, $this->_level);
       
        return $datas;
    }  

    /* 
    * récup. donnée pour affichages variables Header et footer
    * @param  string (level N1 <= home controlleur)
    * @return [[]]
    */
    public function bookPromotedList($level)
    {
        $datas  =   $this->_bookManager->selBookPromotedList($level);
      //  var_dump($datas); 
        return $datas;
    }  
   
}