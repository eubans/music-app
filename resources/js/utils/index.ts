import moment from "moment";

/**
 * Convert seconds to a time string in the format "mm:ss".
 *
 * @param {number} seconds - The number of seconds to convert.
 * @returns {string} The formatted time string.
 */
export const convertSecondsToTime = (seconds: number): string =>
    moment.utc(seconds * 1000).format("mm:ss");
