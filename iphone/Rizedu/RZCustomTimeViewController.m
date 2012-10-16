//
//  RZCustomTimeViewController.m
//  Rizedu
//
//  Created by Tao Xie on 10/14/12.
//  Copyright (c) 2012 Tao Xie. All rights reserved.
//

#import "RZCustomTimeViewController.h"
#import <QuartzCore/QuartzCore.h>

@interface RZCustomTimeViewController () <UIPickerViewDelegate> {
    
}
@property (nonatomic, strong) IBOutlet UIDatePicker *datePicker;
@property (nonatomic, strong) IBOutlet UIBarButtonItem *closeButton;
@property (nonatomic, strong) IBOutlet UILabel *timeLabel;
@end

@implementation RZCustomTimeViewController

- (void)closeButtonPressed:(id)sender {
    // [self dismissModalViewControllerAnimated:YES];
    
//    // Animation to mimic modal view effect (top-down raise)
//    CATransition *transition = [CATransition animation];
//    transition.duration = 1.0f;
//    
//    transition.timingFunction = [CAMediaTimingFunction functionWithName:kCAMediaTimingFunctionDefault];
//    transition.type = kCATransitionMoveIn;
//    transition.subtype = kCATransitionFromBottom;
//    transition.delegate = self;
//    [self.navigationController.view.layer addAnimation:transition forKey:nil];
//    
//    [self.navigationController popViewControllerAnimated:NO];
    [self dismissViewControllerAnimated:YES completion:nil];

}
- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [_datePicker addTarget:self action:@selector(changeDateInLabel:) forControlEvents:UIControlEventValueChanged];
    [_closeButton setAction:@selector(closeButtonPressed:)];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

# pragma mark UIPickerViewDelegate
- (void)changeDateInLabel:(id)sender{
	//Use NSDateFormatter to write out the date in a friendly format
    NSDateFormatter *dateFormat = [[NSDateFormatter alloc] init];
    [dateFormat setDateFormat:@"hh:mma"];
    NSString *dateString = [dateFormat stringFromDate:_datePicker.date];
    _timeLabel.text = [NSString stringWithFormat:@"%@", dateString];
}

@end
