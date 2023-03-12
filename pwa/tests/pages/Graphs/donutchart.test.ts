import { describe } from "node:test";
import { fetchSalesByRegionData } from "../../../pages/Graphs/donutchart";
// test variables
const regions = ['Normandie', 'Bretagne', 'Occitanie'];
const n1=12;
const n2=15;
const n3=18;
describe('fetchSalesByRegionData', () => {
    it('should make a GET request to the correct API endpoint', async () => {
        // Mock the fetch API function
        const mockFetch = jest.fn();
        (window as any).fetch = mockFetch;

        // Define the expected parameters for the fetch call
        const expectedUrl = 'https://localhost/sales_by_region';
        const expectedOptions = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        };

        // Call the function being tested
        await fetchSalesByRegionData("2021");

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
                    { region: regions[0], numberSales: n1 },
                    { region: regions[1], numberSales: n2 },
                    { region: regions[2], numberSales: n3 },
                ]),
        };
        mockFetch.mockResolvedValue(mockResponse);

        // Call the function being tested
        const result = await fetchSalesByRegionData("2021");

        // Verify that the function returns the expected data
        expect(result).toEqual([
            { region: regions[0], numberSales: n1 },
            { region: regions[1], numberSales: n2 },
            { region: regions[2], numberSales: n3 },
        ]);
    });
});
describe('DonutChart', () => {
    it('should render a donut chart', () => {
        // Render the component being tested
        const { container } = render(<DonutChart />);

        // Verify that the component renders the expected elements
        expect(container.querySelector('h2')).toHaveTextContent('Sales by region');
        expect(container.querySelector('svg')).toBeInTheDocument();

        // Verify that the component renders the expected number of bars
        const bars = container.querySelectorAll('rect');
        expect(bars).toHaveLength(3);

        // Verify that the component renders the expected bar labels
        const labels = container.querySelectorAll('text');
        expect(labels).toHaveLength(3);
        expect(labels[0]).toHaveTextContent('Normandie');
        expect(labels[1]).toHaveTextContent('Bretagne');
        expect(labels[2]).toHaveTextContent('Occitanie');
    });
});
