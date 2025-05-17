describe('Example Test Suite', () => {
  it('Visits the homepage and checks the title', () => {
    cy.visit('/');
    cy.title().should('eq', 'Nette Web');
    cy.get('h1').should('contain', 'Nette Blog');
  });

  it('Signs in', () => {
    cy.visit('/sign/in');
    cy.get('input[name="username"]').type('admin');
    cy.get('input[name="password"]').type('secret');
    cy.get('input[type="submit"]').click();
    cy.reload();
    cy.get('.success').should('contain', 'You have been signed in');
  });
});
