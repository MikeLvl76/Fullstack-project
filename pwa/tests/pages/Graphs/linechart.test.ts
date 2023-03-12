import { it } from "node:test";
import { fetchAveragePriceData } from "../../../pages/Graphs/linechart";
const str_date=['2021-01-01','2021-01-02' ,'2021-01-03'];
const n1=12;
const n2=15;
const n3=18;
describe('fetchAveragePriceData', () => {
    it('should make a GET request to the correct API endpoint', async () => {
        // Mock the fetch API function
        const mockFetch = jest.fn();
        (window as any).fetch = mockFetch;

        // Define the expected parameters for the fetch call
        const expectedUrl = 'https://localhost/average_price_by_date/day/2022-01-01/2022-01-03';
        const expectedOptions = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        };

        // Call the function being tested
        await fetchAveragePriceData();

        // Verify that fetch was called with the expected parameters
        expect(mockFetch).toHaveBeenCalledWith(expectedUrl, expectedOptions);
    });

    it('should return an array of data objects', async () => {
        // Mock the fetch API function
        const mockFetch = jest.fn();
        (window as any).fetch = mockFetch;

        // Define the response that the mock fetch function should return
        const mockResponse = {
            ok: true,
            json: () =>
                Promise.resolve([
                    { date: str_date[0], averagePrice: n1 },
                    { date: str_date[1], averagePrice: n2 },
                    { date: str_date[2], averagePrice: n3 },
                ]),
        };
        mockFetch.mockResolvedValue(mockResponse);

        // Call the function being tested
        const result = await fetchAveragePriceData();

        // Verify that the function returns the expected data
        expect(result).toEqual([
            { date: str_date[0], averagePrice: n1 },
            { date: str_date[1], averagePrice: n2 },
            { date: str_date[2], averagePrice: n3 },
        ]);
    });
    
});

