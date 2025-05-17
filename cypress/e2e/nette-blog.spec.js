function signIn() {
    cy.visit('/sign/in');
    cy.get('input[name="username"]').type('admin');
    cy.get('input[name="password"]').type('secret');
    cy.get('input[type="submit"]').click();
}

describe('Nette Blog Test Suite', () => {
  it('Visits the homepage and checks the title', () => {
    cy.visit('/');
    cy.title().should('eq', 'Nette Web');
    cy.get('h1').should('contain', 'Nette Blog');
  });

  it('Signs in', () => {
    signIn();
    cy.reload();
    cy.get('.success').should('contain', 'You have been signed in');
  });

  it('Signs out', () => {
    cy.visit('/sign/out');
    cy.reload();
    cy.get('.success').should('contain', 'You have been signed out');
  });

  it('Adds a post', () => {
    signIn();

    const title = 'Cypress';
    const content = 'Cypress is a JavaScript end-to-end testing framework';

    cy.visit('/edit/add');
    cy.get('input[name="title"]').type(title);
    cy.get('textarea[name="content"]').type(content);
    cy.get('input[type="submit"]').click();
    cy.reload();
    cy.get('.success').should('contain', 'Post published successfully.');
    cy.get('h1').should('contain', title);
  });

  it('Deletes a post', () => {
    signIn();

    cy.get('h2').first().find('a').click();
    cy.reload();
    cy.get('section').find('a').contains('Delete').click();
    cy.reload();
    cy.get('input[type="submit"]').click();
    cy.reload();
    cy.get('.success').should('contain', 'Post deleted');
  })

  it('Updates a post', () => {
    signIn();

    const newTitle = 'New Title';
    const newContent = 'New Content';

    cy.get('h2').first().find('a').click();
    cy.reload();
    cy.get('section').find('a').contains('Edit').click();
    cy.reload();
    cy.get('input[name="title"]').type(newTitle);
    cy.get('textarea[name="content"]').type(newContent);
    cy.get('input[type="submit"]').click();
    cy.reload();
    cy.get('.success').should('contain', 'Post published successfully.');
    cy.get('h1').first().should('contain', newTitle);
  });

  it('Adds a comment', () => {
    signIn();

    const name = 'Cypress Test Script';
    const email = 'test@cypress.com';
    const comment = 'This is a test comment from Cypress';

    cy.get('h2').first().find('a').click();
    cy.reload();

    cy.get('input[name="name"]').type(name);
    cy.get('input[name="email"]').type(email);
    cy.get('textarea[name="content"]').type(comment);
    cy.get('input[type="submit"]').click();
    cy.reload();

    cy.get('.success').should('contain', 'Comment added successfully.');
  });

  it('Tries to go to the add page without being signed in', () => {
    cy.visit('/edit/add');
    cy.get('h1').first().should('contain', "Sign In");
  });

  it('Should not be able to delete posts when not signed in', () => {
    cy.request('POST', '/delete/delete/1').its('body').should('include', '<h1>Sign In</h1>')
  });

  it('Should not be able to edit posts when not signed in', () => {
    cy.request('POST', '/edit/edit/1').its('body').should('include', '<h1>Sign In</h1>')
  });
});

