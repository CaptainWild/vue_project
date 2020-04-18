<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Ptw;

class PermitToWorkUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ptw;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ptw $ptw)
    {
        $this->ptw = $ptw;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {        
        $mailMessage = new MailMessage();

        $mailMessage->from(env('MAIL_FROM_ADDRESS','intellisafe@intellisolution.tech'),env('MAIL_FROM_NAME','intelliSAFE'));
        
        $ccs = array();
        if($this->ptw->verifier_id > 0 && $this->ptw->signatory_id > 0) {
            $cc = $this->ptw->verifier->email;
            $ccName = $this->ptw->verifier->name;

            $mailMessage->cc($cc,$ccName);
            $ccs[$cc] = $ccName;
        }

        // for ptw that has been approved, revoked, halted, resumed, completed
        // applicant (creator) sa , sa2, am (all user involve in signing the PTW)
        if($this->ptw->signatory_id == 0) {
            foreach($this->ptw->ptwsignees as $key => $ptwsignee) {
                if(!in_array($ptwsignee->signatory->email,array_keys($ccs))) {
                    $ccs[$ptwsignee->signatory->email] = $ptwsignee->signatory->name;
                }
            }
            
            foreach($ccs as $ccEmail => $ccName) {
                $mailMessage->cc($ccEmail,$ccName);
            }
        }
        
        $mailMessage->subject('PTW Notification');
        $mailMessage->line('PTW Application with Ref #. '. $this->ptw->reference_no. ' status is now set as '. $this->ptw->ptwstatus->name .' and your attention is required.');
        $mailMessage->line('PTW Start Date/Time: '. $this->ptw->start_date.' '.$this->ptw->start_time);
        $mailMessage->line('PTW End Date/Time: '. $this->ptw->end_date.' '.$this->ptw->end_time);
        $mailMessage->line('Type of Works Applied: '. $this->ptw->hrw->name);
        $mailMessage->line('Location of Work: '. $this->ptw->location);
        $mailMessage->action('CLICK HERE TO LOGIN', url('http://3.0.19.12'));
        $mailMessage->line('Thank you for using intelliSAFE.');
        $mailMessage->line('This is a system generated message. Please do not reply.Should you have any issue, Please contact your Ops Director.');

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->ptw->id,
            'reference_no' => $this->ptw->reference_no,
            'ptw_status_id' => $this->ptw->ptw_status_id,
        ];
    }
}
