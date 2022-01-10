<?php 

namespace App\Classe;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Adoption
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function add($id)
    {
        $adoption=$this->session->get('adoption', []);

        if(!empty($adoption[$id]))
        {
            $adoption[$id]++;
        }
        else
        {
            $adoption[$id] = 1;
        }

        $this->session->set('adoption', $adoption);
    }

    public function get()
    {
        return $this->session->get('adoption');
    }

    public function remove()
    {
        return $this->session->remove('adoption');
    }

    public function delete($id)
    {
        $adoption = $this->session->get('adoption', []);
        unset($adoption[$id]);       
        return $this->session->set('adoption',$adoption);
    }






}