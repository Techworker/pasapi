<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\Block
 *
 * @property int $id
 * @property int $block
 * @property string $enc_pubkey
 * @property int $reward
 * @property int $fee
 * @property int $ver
 * @property string $payload
 * @property int $n_operations_single
 * @property int $n_operations_multi
 * @property int $volume
 * @property int $duration
 * @property int $n_uniq_senders
 * @property int $n_uniq_receivers
 * @property int $n_uniq_changers
 * @property int $n_uniq_accounts
 * @property int $n_type_0
 * @property int $n_type_1
 * @property int $n_type_2
 * @property int $n_type_3
 * @property int $n_type_4
 * @property int $n_type_5
 * @property int $n_type_6
 * @property int $n_type_7
 * @property int $n_type_8
 * @property int $n_type_9
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $tstamp
 * @property int $hashrate
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereBlock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereEncPubkey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereHashrate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNOperationsMulti($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNOperationsSingle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNType0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNType1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNType2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNType3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNType4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNType5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNType6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNType7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNType8($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNType9($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNUniqAccounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNUniqChangers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNUniqReceivers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereNUniqSenders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereTstamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereVer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Block whereVolume($value)
 */
	class Block extends \Eloquent {}
}

