<?php
class Book extends Table
{
    private $_id;
    private $_title;
    private $_plot;
    private $_onlineDat;
    private $_nbEps;
    private $_status;
    private $_isbn;
    private $_editYear;
    private $_cover;
    private $_coverAlt;
    private $_promoted;
/**
     * Variablea ajoutés hors base données
     */
    private $_episodes;
    private $_nbEpisodes;
    private $_alertEpisode;
    private $_onlineDatLabel;
    private $_promotedLabel;
    private $_coverLabel;
    private $_onlineDatType;
    private $_promotedType;
    private $_coverType;

    private $_statusOkDel = '10';
   
    
     /**
    
     * @param array $donnees
     */
    public function __construct($table)
  {
    parent::__construct($table);
        
    if($this->getStatus() >= '20') : 
        $this->setOnlineDatLabel('Mis en ligne le....:');
        $this->setPromotedLabel('Mis en ligne le....:'); 
        $this->setOnlineDatType('date');
        $this->setPromotedType('date');
     else:
        $this->setOnlineDatLabel('hors ligne');
        $this->setPromotedLabel(''); 
        $this->setOnlineDatType('hidden');
        $this->setPromotedType('hidden');
    endif;
  }
    /**
     * @param array $donnees
     */
    public function hydrate($dtas)
    {
        if(is_array($dtas))
        {
            foreach ($dtas as $key => $value)
            {
                $method = 'set' . ucfirst($key);
                if(method_exists($this, $method))
                {
                    $this->$method($value);
                }
            }
        }
    }

// Setters
    public function setId($id)
    {
        $this->_id = (int) $id;
    }
    public function setTitle($title)
    {
        $this->_title = $title;
    }
    public function setPlot($plot)
    {
        $this->_plot = $plot;
    }
    public function setOnlineDate(datetime $onlineDate)
    {
       //  $onlineDate = new DateTime();
      // $this->_onlineDate = ($onlineDate !='') ? date('Y-m-d', strtotime($onlineDate)) : null;
       $this->_onlineDate = $this->cvtDat($onlineDate, 'set', false);
    }
    public function setNbEps($nbEps)
    {
        $this->_nbEps = (int) $nbEps;
    }
    public function setStatus($status)
    {
        $this->_status = $status;
      

    }
    public function setIsbn($isbn)
    {
        $this->_isbn = $isbn;
    }
    public function setEditYear($editYear)
    {
        $this->_editYear = (int) $editYear;
    }
    public function setCover($cover)
    {
        $this->_cover =  $cover;
        $this->setCoverLabel('Couverture........:');
        $this->setCoverType('text');
    }
    public function setCoverAlt($coverAlt)
    {
        $this->_coverAlt =  $coverAlt;
    }

    public function setPromoted($promoted)
    {
        $this->_promoted =  (int) $promoted;
    }

    // Getters
    public function getId()
    {
        return $this->_id;
    }
    public function getTitle()
    {
        return $this->_title;
    }
    public function getPlot()
    {
        return $this->_plot;
    }
    public function getOnlineDat()
    {
        return $this->_onlineDat;
    }
    public function getNbEps()
    {
        return $this->_nbEps;
    }
    public function getStatus()
    {
        return $this->_status;
    }
    public function getIsbn()
    {
        return $this->_isbn;
    }
    public function getEditYear()
    {
        return $this->_editYear;
    }
    public function getCover()
    {
        return $this->_cover;
    }
    public function getCoverAlt()
    {
        return $this->_coverAlt;
    }
    public function getPromoted()
    {
        return $this->_promoted;
    }

    public function isNew()
    {
        return empty($this->_id);
    }


    /**
     * Fonction annexes _____________________________________________SET
     */

    public function setEpisodes($episodes)   // tableau d'objets Episode
    {
        $this->_episodes = $episodes;
        $this->setNbEpisodes(count($episodes));
        
        if($this->getNbEpisodes() > 0 && $this->getStatus() === '10'):
            $this->setStatus('20');
        endif;
    }

    public function setNbEpisodes($nbEpisodes)
    {
        
        $this->_nbEpisodes = (int) $nbEpisodes;
        $this->setNbEpisodesLabel('Nb épisodes........:');
        $this->setNbEpisodesType('number');  
    }

    
    /**
     * @parm mixed      (tableau ou false)
     * @return mixed    (count ou false)
     */
    public function setAlertEpisode($altE)
    {
        if(is_array($altE)) : 
            $alt = count( array_column($altE, '_alertComm'));          
        endif;
        $this->_alertEpisode = (int) $alt;
      
    }

    public function setOnlineDatLabel($label)
    {

        $this->_onlineDatLabel = $label;
    }
    public function setOnlineDatType($type)
    {

        $this->_onlineDatType = $type;
    }
    public function setPromotedLabel($label)
    {

        $this->_promotedLabel = $label;
    }
    public function setPromotedType($type)
    {

        $this->_promotedType = $type;
    }
    public function setNbEpisodesLabel($label)
    {

        $this->_nbEpisodesLabel = $label;
    }
    public function setNbEpisodesType($type)
    {

        $this->_nbEpisodesType = $type;
    }
    public function setCoverLabel($label)
    {

        $this->_coverLabel = $label;
    }
    public function setCoverType($type)
    {

        $this->_coverType = $type;
    }
     /**
    *  Fonction annexes  _____________________________________________GET
    */
   
   public function getEpisodes()
   {
       return $this->_episodes;
   }

       public function getNbEpisodes()
    {
        return $this->_nbEpisodes;
    }
    public function getAlertEpisode()
    {
        return $this->_alertEpisode;
    }
    public function getOnlineDatLabel(){

        return $this->_onlineDatLabel;
    }
    public function getOnlineDatType(){

        return $this->_onlineDatType;
    }
    public function getPromotedLabel(){

        return $this->_promotedLabel;
    }
    public function getPromotedType(){

        return $this->_promotedType;
    }
    public function getNbEpisodesLabel(){

        return $this->_nbEpisodesLabel;
    }
    public function getNbEpisodesType(){

        return $this->_nbEpisodesType;
    }
    public function getCoverLabel(){

        return $this->_coverLabel;
    }
    public function getCoverType(){

        return $this->_coverType;
    }


  /**
    *  Fonction annexes  _____________________________________________Validation/MAJ
    */
    public static function validation()
    {
    $validTable =       array('id'        =>array(
                            'Reference'     =>'Identifiant',
                            'required'      => false
                            ),
            'title'     =>array(
                            'Reference'     =>'Titre',
                            'required'      => true,
                            'min'           => 3,
                            'max'           => 50
                            ),
            'plot'      =>array(
                            'Reference'     =>'intrigue',
                            'required'      => true,
                            'min'           => 10,
                            'max'           => 2000
                            ),
            'onlineDat' =>array(
                            'Reference'     =>'En ligne',
                            'required'      => false,    
                            ),
            'nbEps'     =>array(
                            'Reference'     =>'Nb Episodes',
                            'required'      => false
                          ),
            'status'    =>array(
                            'Reference'     =>'statut',
                            'required'      => true,
                            'max'           => 2,
                            'list'          => '00;10;30;80;90'
                          ),
            'isbn'      =>array(
                            'Reference'     =>'isbn',
                            'required'      => false,
                            'max'           => 20
                            // 'unique'        => 'book'
                          ),
            'editYear'      =>array(
                                'Reference'     =>'Année édit°',
                                'required'      => false,
                                'max'           => 4
                            ),
            'cover'         =>array(
                                'Reference'     =>'Couverture',
                                'required'      => false,
                                'max'           => 30
                            ),
            'coverAlt'         =>array(
                            'Reference'     =>'Legende',
                            'required'      => false,
                            'max'           => 50
                            ),
            'promoted'        =>array(
                                'Reference'     =>'Mis en avant',
                                'required'      => false,
                                'max'           => 1
                            )
                                        
      ); 
      return $validTable;
    }
}
