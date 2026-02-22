local indexKey = KEYS[1]
local cutoff = tonumber(KEYS[2])

local hashNames = redis.call(
    'ZRANGEBYSCORE',
    indexKey,
    0,
    cutoff
)

if #hashNames == 0 then
    return 0
end

for i = 1, #hashNames do
    redis.call('DEL', hashNames[i])
end

redis.call('ZREMRANGEBYSCORE', indexKey, 0, cutoff);

return 1
