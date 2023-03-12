import React from 'react';
import { render } from '@testing-library/react';
import Graphs from '../../pages/Graphs';

test('renders Header, TabsContainer, and Footer components', () => {
  const { getByTestId, getByRole } = render(<Graphs />);
  const header = getByTestId('header');
  const tabsContainer = getByRole('tablist');
  const footer = getByTestId('footer');
  expect(header).toBeInTheDocument();
  expect(tabsContainer).toBeInTheDocument();
  expect(footer).toBeInTheDocument();
});
test('renders correct number of tabs with correct labels', () => {
  const { getAllByRole } = render(<Graphs />);
    const tabs = getAllByRole('tab');
  expect(tabs.length).toBe(3);
  const tabLabels = ['Série temporelle', 'Diagramme à barre', 'Diagramme circulaire'];
  tabLabels.forEach(label => {
    const tab = getByText(label);
    expect(tab).toBeInTheDocument();
  });
});

