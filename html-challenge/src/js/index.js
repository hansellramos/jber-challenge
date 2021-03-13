/**
 * Returns human readable time format
 * @param date
 * @param now
 * @returns {string}
 * @private
 */
const _format = (date, now) => {
    const dTime = date.getTime()
    const nTime = now.getTime()
    const diff = nTime - dTime
    const MSPM = 60000

    // is right now
    if (diff === 0) {
        return "now";
    }

    // if lower than 2 seconds
    if (diff < 2000) {
        return '1 second ago'
    }

    // if lower than 1 minute
    if (diff < MSPM) {
        const value = Math.floor(diff / MSPM * 60);
        return `${value} seconds ago`
    }

    // if lower than 2 minutes
    if (diff < 2 * MSPM) {
        return '1 minute ago'
    }

    // if lower or equal than 59 minutes or one hour
    if (diff <= 59 * MSPM) {
        const value = Math.floor(diff / MSPM)
        return `${value} minutes ago`
    }

    // if lower than 2 hours
    if (diff < 2 * 60 * MSPM) {
        return '1 hour ago'
    }

    // if lower than 3600 seconds or 1 hour
    if (diff < 24 * 60 * MSPM) {
        const value = Math.floor(diff / 60 / MSPM)
        return `${value} hours ago`
    }

    // if lower than 2 days
    // if (diff < 48 * 60 * MSPM) {
    //     return '1 day ago'
    // }

    return date.toISOString()
}

module.exports = _format
