import React from 'react';
import { render } from '@testing-library/react';
import Index from './Index';

test('renders heading with correct text', () => {
  const { getByText } = render(<Index />);
  const heading = getByText("Les agences immobilières en France");
  expect(heading).toBeInTheDocument();
});
test('renders Header and Footer components', () => {
  const { getByTestId } = render(<Index />);
  const header = getByTestId('header');
  const footer = getByTestId('footer');
  expect(header).toBeInTheDocument();
  expect(footer).toBeInTheDocument();
});