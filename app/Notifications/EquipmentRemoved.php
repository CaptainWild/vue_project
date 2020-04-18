<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Ptw;
use App\Equip;

class EquipmentRemoved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ptw;
    protected $equip;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Equip $equip,Ptw $ptw)
    {
        $this->ptw = $ptw;
        $this->equip = $equip;
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
        
        $mailMessage->subject('('.$this->equip->name.') Equipment Deletion');
        $mailMessage->line('Equipment Name '. $this->equip->name.' and LM No.:'. $this->equip->lm_no. ' is has been DELETED in the system.');
        $mailMessage->line('Please see affected PTW Application Ref #. : '. $this->ptw->reference_no. ' ('. $this->ptw->ptwstatus->name .').');

        $mailMessage->action('CLICK HERE TO LOGIN', url('http://3.0.19.12'));
        $mailMessage->line('Thank you for using intelliSAFE.');
        $mailMessage->line('This is a system generated message. Please do not reply. Should you have any issue, Please contact your Ops Director.');

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
            'equip_id' => $this->equip->id,
            'ptw_id' => $this->ptw->id,
        ];
    }
}
