<?php
class ob_newsletter
{
    public $id;
    public $email;
    public $active;
    public $subscribed_at;
    public $unsubscribed_at;
    public $unsubscribe_token;

    public function reset()
    {
        $this->id = 0;
        $this->email = '';
        $this->active = 1;
        $this->subscribed_at = '';
        $this->unsubscribed_at = null;
        $this->unsubscribe_token = '';
    }
}
?>
