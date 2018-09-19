@if($opType === \Techworker\PascalCoin\PascalCoin::OP_TYPE_TRANSACTION)
    Transaction
@elseif($opType === \Techworker\PascalCoin\PascalCoin::OP_TYPE_CHANGE_KEY)
    Change Key
@elseif($opType === \Techworker\PascalCoin\PascalCoin::OP_TYPE_RECOVER_FUNDS)
    Recover Funds
@elseif($opType === \Techworker\PascalCoin\PascalCoin::OP_TYPE_LIST)
    List Account For Sale
@elseif($opType === \Techworker\PascalCoin\PascalCoin::OP_TYPE_DELIST)
    De-List Account
@elseif($opType === \Techworker\PascalCoin\PascalCoin::OP_TYPE_BUY)
    Buy Account
@elseif($opType === \Techworker\PascalCoin\PascalCoin::OP_TYPE_CHANGE_KEY_SIGNED)
    Change Key (Signed)
@elseif($opType === \Techworker\PascalCoin\PascalCoin::OP_TYPE_CHANGE_INFO)
    Change Info
@elseif($opType === \Techworker\PascalCoin\PascalCoin::OP_TYPE_MULTI)
    Multi-Operation
@else
    Unknown
@endif