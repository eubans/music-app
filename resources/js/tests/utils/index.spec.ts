import { describe, expect, test } from 'vitest'
import { convertSecondsToTime } from "@/utils";

describe("convertSecondsToTime", () => {
    test('should convert 0 seconds to "00:00"', () => {
        expect(convertSecondsToTime(0)).toBe("00:00");
    });

    test('should convert 30 seconds to "00:30"', () => {
        expect(convertSecondsToTime(30)).toBe("00:30");
    });

    test('should convert 60 seconds to "01:00"', () => {
        expect(convertSecondsToTime(60)).toBe("01:00");
    });

    test('should convert 90 seconds to "01:30"', () => {
        expect(convertSecondsToTime(90)).toBe("01:30");
    });
});
