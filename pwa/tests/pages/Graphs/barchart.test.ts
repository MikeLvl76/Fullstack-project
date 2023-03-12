import { fetchNumberOfSalesData } from "../../../pages/Graphs/barchart";
import { render, screen } from '@testing-library/react';
import React from 'react';
import Bar from './Bar';
// tests variables
const str_date=['2021-01-01','2021-01-02' ,'2021-01-03'];
const n1=12;
const n2=15;
const n3=18;
describe('fetchNumberOfSalesData', () => {
  it('should make a GET request to the correct API endpoint', async () => {
    // Mock the fetch API function
    const mockFetch = jest.fn();
    (window as any).fetch = mockFetch;

    // Define the expected parameters for the fetch call
    const expectedUrl = 'https://localhost/number_sales_by_date/day/2022-01-01/2022-01-03';
    const expectedOptions = {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
      },
    };

    // Call the function being tested
    await fetchNumberOfSalesData(['day', str_date[0], str_date[2]]);

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
          { date: str_date[0], numberSales: n1 },
          { date: str_date[1], numberSales: n2 },
          { date: str_date[2], numberSales: n3 },
        ]),
    };
    mockFetch.mockResolvedValue(mockResponse);

    // Call the function being tested
    const result = await fetchNumberOfSalesData(['day', '2022-01-01', '2022-01-03']);

    // Verify that the function returns the expected data
    expect(result).toEqual([
      { date: str_date[0], numberSales: n1 },
      { date: str_date[1], numberSales: n2 },
      { date: str_date[2], numberSales: n3 },
    ]);
  });
});
describe('Bar', () => {
  it('should render a bar chart with the correct dimensions', () => {
    const width = 500;
    const height = 300;

    render(<Bar width={width} height={height} />);

    // Get the rendered SVG element
    const svg = screen.getByTestId('bar-chart');

    // Verify the width and height of the SVG element
    expect(svg).toHaveAttribute('width', `${width}`);
    expect(svg).toHaveAttribute('height', `${height}`);
  });
});