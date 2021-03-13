const _format = require('../index')

test('should return "now"', () => {
    const NOW = new Date()
    expect(_format(NOW, NOW)).toBe('now')
})

test('should return "1 second ago"', () => {
    const NOW = new Date()
    expect(_format(NOW, NOW)).not.toBe('1 second ago')
    expect(_format(new Date(NOW - 1), NOW)).toBe('1 second ago')
    expect(_format(new Date(NOW - 1000), NOW)).toBe('1 second ago')
    expect(_format(new Date(NOW - 1999), NOW)).toBe('1 second ago')
    expect(_format(new Date(NOW - 2000), NOW)).not.toBe('1 second ago')
})

test('should return "2 seconds ago"', () => {
    const NOW = new Date()
    expect(_format(new Date(NOW - 1999), NOW)).not.toBe('2 seconds ago')
    expect(_format(new Date(NOW - 2000), NOW)).toBe('2 seconds ago')
    expect(_format(new Date(NOW - 2000 + 1), NOW)).not.toBe('2 seconds ago')
    expect(_format(new Date(NOW - 2000 + 999), NOW)).not.toBe('2 seconds ago')
    expect(_format(new Date(NOW - 3000), NOW)).not.toBe('2 seconds ago')
})

test('should return "59 seconds ago"', () => {
    const NOW = new Date()
    expect(_format(new Date(NOW - 58 * 1000), NOW)).not.toBe('59 seconds ago')
    expect(_format(new Date(NOW - 59 * 1000), NOW)).toBe('59 seconds ago')
    expect(_format(new Date(NOW - 59 * 1000 - 999), NOW)).toBe('59 seconds ago')
    expect(_format(new Date(NOW - 59 * 1000 - 1), NOW)).toBe('59 seconds ago')
    expect(_format(new Date(NOW - 60 * 1000), NOW)).not.toBe('59 seconds ago')
})

test('should return "1 minute ago"', () => {
    const NOW = new Date()
    expect(_format(new Date(NOW - 60000), NOW)).toBe('1 minute ago')
    expect(_format(new Date(NOW - 61000), NOW)).toBe('1 minute ago')
    expect(_format(new Date(NOW - 2 * 60000 + 1), NOW)).toBe('1 minute ago')
    expect(_format(new Date(NOW - 2 * 60000), NOW)).not.toBe('1 minute ago')
})

test('should return "2 minutes ago"', () => {
    const NOW = new Date()
    expect(_format(new Date(NOW - 2 * 60000 + 1), NOW)).not.toBe('2 minutes ago')
    expect(_format(new Date(NOW - 2 * 60000), NOW)).toBe('2 minutes ago')
    expect(_format(new Date(NOW - 2 * 60000 + 999), NOW)).not.toBe('2 minutes ago')
    expect(_format(new Date(NOW - 3 * 60000), NOW)).not.toBe('2 minutes ago')
})

test('should return "59 minutes ago"', () => {
    const NOW = new Date()
    expect(_format(new Date(NOW - 59 * 60000 + 1), NOW)).not.toBe('59 minutes ago')
    expect(_format(new Date(NOW - 59 * 60000), NOW)).toBe('59 minutes ago')
    expect(_format(new Date(NOW - 59 * 60000 + 999), NOW)).not.toBe('59 minutes ago')
    expect(_format(new Date(NOW - 60 * 60000), NOW)).not.toBe('59 minutes ago')
})

test('should return "1 hour ago"', () => {
    const NOW = new Date()
    expect(_format(new Date(NOW - 60 * 60000), NOW)).toBe('1 hour ago')
    expect(_format(new Date(NOW - 60 * 60000 - 1000), NOW)).toBe('1 hour ago')
    expect(_format(new Date(NOW - 60 * 60000 + 1), NOW)).toBe('1 hour ago')
    expect(_format(new Date(NOW - 2 * 60 * 60000), NOW)).not.toBe('1 hour ago')
})

test('should return "23 hours ago"', () => {
    const NOW = new Date()
    expect(_format(new Date(NOW - 23 * 60 * 60000), NOW)).toBe('23 hours ago')
    expect(_format(new Date(NOW - 23 * 60 * 60000 - 1000), NOW)).toBe('23 hours ago')
    expect(_format(new Date(NOW - 23 * 60 * 60000 + 1), NOW)).not.toBe('23 hours ago')
    expect(_format(new Date(NOW - 24 * 60 * 60000), NOW)).not.toBe('23 hours ago')
})
