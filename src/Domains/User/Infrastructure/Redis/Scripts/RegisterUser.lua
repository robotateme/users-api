-- ARGV[1] = user key (user:{nickname})
-- ARGV[2] = users index (users:index)
-- ARGV[3] = nickname
-- ARGV[4] = avatar
-- ARGV[5] = timestamp

if redis.call("EXISTS", ARGV[1]) == 1 then
    return 0
end

redis.call("HSET", ARGV[1],
    "nickname", ARGV[3],
    "avatar", ARGV[4],
    "created_at", ARGV[5]
)

redis.call("ZADD", ARGV[2], ARGV[5], ARGV[1])

return 1
